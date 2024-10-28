<?php

namespace FS\ZoomMeeting\Pub\Controller;

use XF\Mvc\ParameterBag;
use XF\Pub\Controller\AbstractController;

class Meeting extends AbstractController {

    public function preDispatchController($action, ParameterBag $params) {

        $visitor = \xf::visitor();

        if (!$visitor->canViewMeetings()) {
              throw $this->exception($this->noPermission());
        }
    }

    public function actionIndex(ParameterBag $params) {
        
        $page = 0;
        $perPage = 0;
        $categories = $this->finder('FS\ZoomMeeting:Category');
        $categoryTree = $this->createCategoryTree($categories->fetch());

        if ($this->filter('search', 'uint')) {
            $finder = $this->getSearchFinder();

           
        } else if ($params->category_id) {
            
            $finder = $this->finder('FS\ZoomMeeting:Meeting');

            $finder->where('category_id', $params->category_id);
            
        } else {

            $options = \XF::options();
            $perPage = 10;

            $page = $params->page;

            $finder = $this->finder('FS\ZoomMeeting:Meeting');

            $finder->limitByPage($page, $perPage);
            $finder->order('start_time', 'ASC');
        }


        $viewParams = [
            'categories' => $categories,
            'categoryTree' => $categoryTree,
            'meetings' => $finder->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'totalReturn' => count($finder->fetch()),
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('FS\Meeting:Meeting', 'zoom_meetings', $viewParams);
    }
    
     public function actioncategories(ParameterBag $params) {
        
         
        
        $page = 0;
        $perPage = 0;
        $categories = $this->finder('FS\ZoomMeeting:Category');
        $categoryTree = $this->createCategoryTree($categories->fetch());

        if ($params->category_id) {
            
            $finder = $this->finder('FS\ZoomMeeting:Meeting');

            $finder->where('category_id', $params->category_id);
            
        } else {

            $options = \XF::options();
            $perPage = 10;

            $page = $params->page;

            $finder = $this->finder('FS\ZoomMeeting:Meeting');

            $finder->limitByPage($page, $perPage);
            
            $finder->order('start_time', 'ASC');
        }


        $viewParams = [
            'categories' => $categories,
            'categoryTree' => $categoryTree,
            'meetings' => $finder->fetch(),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $finder->total(),
            'totalReturn' => count($finder->fetch()),
            'conditions' => $this->filterSearchConditions(),
        ];

        return $this->view('FS\Meeting:Meeting', 'zoom_meetings', $viewParams);
    }

    public function actionRefineSearch(ParameterBag $params) {
        $categories = $this->finder('FS\ZoomMeeting:Category')->fetch();

        $viewParams = [
            'conditions' => $this->filterSearchConditions(),
            'categories' => $categories,
        ];

        return $this->view('FS\Meeting:Meeting\RefineSearch', 'meeting_search_filter', $viewParams);
    }

    protected function filterSearchConditions() {
        return $this->filter([
                    'username' => 'str',
                    'status' => 'int',
                    'category_id' => 'int',
        ]);
    }

    public function actionView(ParameterBag $params) {

        $meeting = $this->assertMeetingExists($params->meeting_id);

        $otherMeetings = $this->getMeetingRepo()
                ->categoryMeeting($meeting->category_id, $meeting)
                ->fetch(5);

        $viewParams = [
            'meeting' => $meeting,
            'otherMeetings' => $otherMeetings,
        ];
        return $this->view('FS\Meeting:Meeting', 'zoom_meeting_view', $viewParams);
    }

    protected function assertMeetingExists($id, $with = null, $phraseKey = null) {
        return $this->assertRecordExists('FS\ZoomMeeting:Meeting', $id, $with, $phraseKey);
    }

    protected function getMeetingRepo() {
        return $this->repository('FS\ZoomMeeting:Meeting');
    }

//    public function actionjoin(ParameterBag $params) {
//
//        $visitor = \xf::visitor();
//        $meeting = $this->assertMeetingExists($params->meeting_id);
//
//        if (count($meeting->join_usergroup_ids) && !$visitor->isMemberOf($meeting->join_usergroup_ids)) {
//
//            throw $this->exception($this->noPermission());
//        }
//
//        if ($meeting->isJoined()) {
//
//            throw $this->exception(\xf::phrase('you_have_alread_join_meeting'));
//        }
//
//
//        if ($this->isPost()) {
//
//            $meetingService = $this->service('FS\ZoomMeeting:Meeting');
//            $meetingService->newJoin($visitor, $meeting);
//            return $this->redirect($this->buildLink('meetings/view', $meeting));
//        }
//
//
//        $viewParams = [
//            'meeting' => $meeting,
//        ];
//        return $this->view('FS\Meeting:Meeting', 'join_zoom_meeting', $viewParams);
//    }

    public function actionjoiners(ParameterBag $params) {

        $visitor = \xf::visitor();
        $meeting = $this->assertMeetingExists($params->meeting_id);

        $finder = $this->finder('FS\ZoomMeeting:Register');
        $finder->where('meeting_id', $meeting->z_meeting_id);
        $finder->order('join_date', 'desc');

        $total = $finder->total();
        $page = $this->filterPage();
        $perPage = 10;

        $users = $finder->limitByPage($page, $perPage)->fetch();

        $viewParams = [
            'meeting' => $meeting,
            'users' => $users,
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total
        ];
        return $this->view('', 'zoom_meeting_joiners', $viewParams);
    }

    protected function getSearchFinder() {
        $conditions = $this->filterSearchConditions();

        $finder = $this->finder('FS\ZoomMeeting:Meeting');

        if ($conditions['username'] != '') {

            $User = $this->finder('XF:User')->where('username', $conditions['username'])->fetchOne();
            if ($User) {
                $finder->where('user_id', $User->user_id);
            }
        }

       
        if ($conditions['status'] != 0) {

            if ($conditions['status'] == '1') {

                $finder->where('start_time', '<', \XF::$time)->where('end_time', '>', \XF::$time);
            }
            if ($conditions['status'] == '2') {

                $finder->where('start_time', '>', \XF::$time);
            }
            if ($conditions['status'] == '3') {

                $finder->where('start_time', '<', \XF::$time);
            }
        }


        $finder->order('start_time','ASC');
        if ($conditions['category_id'] != '0') {
            $finder->where('category_id', $conditions['category_id']);
        }

        return $finder;
    }

    /**
     * @param null $categories
     * @param int $rootId
     *
     * @return \XF\Tree
     */
    public function createCategoryTree($categories = null, $rootId = 0) {
        if ($categories === null) {
            $categories = $this->findCategoryList()->fetch();
        }
        return new \XF\Tree($categories, 'parent_category_id', $rootId);
    }

    protected function getCategoryRepo() {
        return $this->repository('FS\ZoomMeeting:Category');
    }
}
