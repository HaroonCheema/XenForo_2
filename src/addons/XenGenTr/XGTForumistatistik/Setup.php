<?php

namespace XenGenTr\XGTForumistatistik;

use XF\AddOn\AbstractSetup;
use XF\AddOn\StepRunnerInstallTrait;
use XF\AddOn\StepRunnerUninstallTrait;
use XF\AddOn\StepRunnerUpgradeTrait;
use XF\Db\Schema\Alter;
use XF\Db\Schema\Create;

class Setup extends AbstractSetup
{
	use StepRunnerInstallTrait;
	use StepRunnerUpgradeTrait;
	use StepRunnerUninstallTrait;

    /**
     * ----------------
     *     Kuruluma zamani
     * ----------------
     */
    public function installStep1()
    {
         $this->schemaManager()->createTable('xgt_forum_istatistik_icerik', function(Create $table)
        {
            $table->addColumn('icerik_id', 'varbinary', 25);
            $table->addColumn('icerik_sinifi', 'varchar', 300);

            $table->addPrimaryKey('icerik_id');
        });

        $this->schemaManager()->createTable('xgt_forum_istatistik', function(Create $table)
        {
            $table->addColumn('veri_id', 'int')->autoIncrement();
            $table->addColumn('icerik_id', 'varbinary', 25);
            $table->addColumn('pozinyon', 'varchar', 30);
            $table->addColumn('veri_ikonu', 'varchar', 50)->nullable();
            $table->addColumn('display_order', 'int');
            $table->addColumn('options', 'blob');
            $table->addColumn('active', 'tinyint', 3);
        });

        $data = [];

        $data['xgt_forum_istatistik_icerik'] = "
            INSERT INTO `xgt_forum_istatistik_icerik` (`icerik_id`, `icerik_sinifi`)
            VALUES
                ('encok_mesaj','XenGenTr\\\\XGTForumistatistik:EncokMesaj'),
                ('encok_tepki','XenGenTr\\\\XGTForumistatistik:EncokTepki'),
                ('encok_goruntulenen','XenGenTr\\\\XGTForumistatistik:EncokGoruntulenen'),
                ('yeni_mesajlar','XenGenTr\\\\XGTForumistatistik:YeniMesajlar'),
                ('yeni_konular','XenGenTr\\\\XGTForumistatistik:YeniKonular')
        ";

        $data['xgt_forum_istatistik'] = "
            INSERT INTO `xgt_forum_istatistik` (`icerik_id`, `veri_ikonu`, `pozinyon`,`display_order`, `options`, `active`)
            VALUES
                ('yeni_mesajlar','fad fa-comment-dots','anaveri',5,'[]',1),
                ('yeni_konular','fad fa-comments','anaveri',10,'[]',1),
                ('encok_mesaj','fad fa-comment-medical','anaveri',15,'[]',1),
                ('encok_tepki','fad fa-thumbs-up','anaveri',20,'[]',1),
                ('encok_goruntulenen','fad fa-street-view','anaveri',25,'[]',1)
        ";

        $db = $this->db();

        foreach ($data AS $dataQuery)
        {
            $db->query($dataQuery);
        }
    }

    public function installStep2()
    {
        $data = [];

        $data['xgt_forum_istatistik_icerik'] = "
            INSERT INTO `xgt_forum_istatistik_icerik` (`icerik_id`, `icerik_sinifi`)
            VALUES
                 ('yeni_kaynaklar', 'XenGenTr\\\\XGTForumistatistik:YeniKaynaklar')
        ";

        $db = $this->db();

        foreach ($data AS $dataQuery)
        {
            $db->query($dataQuery);
        }
    }

    public function installStep3()
    {
        $this->schemaManager()->alterTable('xgt_forum_istatistik', function(Alter $alter)
        {
            $alter->addColumn('custom_title', 'varchar', 50)->nullable();
        });
    }

    public function installStep4()
    {
        $this->createWidget('xgtForumIstatistik_encok_mesaj_kullanici', 'xgtForumIstKullanici_wd', [
            'positions' => []
        ]);
    }

    /**
     * ----------------
     *     Guncellemeler
     * ----------------
     */
    // 2002001 Surum guncellemesi

    public function upgrade2002001Step1()
    {
         $this->deleteWidget('XGT_YeniMesajlar_widget');
		 $this->deleteWidget('XGT_YeniKonular_widget');
		 $this->deleteWidget('XGT_EnCokGrtKonu_widget');
		 $this->deleteWidget('XGT_EnCokCevapKonu_widget');
		 $this->deleteWidget('XGT_EnCokBegenKonu_widget');
		 $this->deleteWidget('XGT_encokmesaj_kullanici');
    }

    public function upgrade2002001Step2()
    {
        $this->installStep1();
		$this->installStep2();
		$this->installStep3();
		$this->installStep4();
    }

    // 3000700 Surum guncellemesi
    public function upgrade3000700Step1()
    {

		$this->installStep2();
    }

    /**
     * ----------------
     *     Temizlik yap
     * ----------------
     */
    public function uninstallStep1()
    {
        $this->schemaManager()->dropTable('xgt_forum_istatistik_icerik');
        $this->schemaManager()->dropTable('xgt_forum_istatistik');
    }

	public function uninstallStep2()
    {
         $this->deleteWidget('xgtForumIstKullanici_wd');
    }
}
