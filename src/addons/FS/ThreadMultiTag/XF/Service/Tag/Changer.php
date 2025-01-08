<?php

namespace FS\ThreadMultiTag\XF\Service\Tag;

use XF\Mvc\Entity\Entity;

class Changer extends XFCP_Changer
{

	public function saveMultiTags($performValidations = true)
	{
		if ($performValidations) {
			if ($this->errors === null) {
				$this->checkForErrors();
			}
			if ($this->errors) {
				throw new \LogicException("There are outstanding errors, cannot save.");
			}
		}

		$this->db()->beginTransaction();

		foreach ($this->createTags as $create) {
			$tag = $this->tagRepo->createTag($create);
			if ($tag) {
				$this->addTags[$tag->tag_id] = $tag->tag;
			}
		}

		$cache = $this->tagRepo->modifyContentMultiTags(
			$this->contentType,
			$this->contentId,
			array_keys($this->addTags),
			array_keys($this->removeTags)
		);

		$this->db()->commit();

		return $cache;
	}
}
