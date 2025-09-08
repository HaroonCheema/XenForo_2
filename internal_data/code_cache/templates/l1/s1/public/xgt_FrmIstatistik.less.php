<?php
// FROM HASH: 5d97403c04e2076802d5f06c803f8b43
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '/************************************************************
*  [XGT] Forum istatistik 4. nesil LESS
*  XGT Yazılım ve web hizmetleri - eTiKeT™
*  www.xenforo.gen.tr
*  Baslangic: 26.01.2020 
*  Son gucelleme: 18.04.2023
************************************************************/
//-- Baglantilar
@xgtFrmistatistik_baglantilar         : @xf-xgt_Frmistatistik_baglantilar;
@xgtFrmistatistik_baglantilar-h       : xf-intensify(@xf-xgt_Frmistatistik_baglantilar, 20%);
//-- Tab butonlar
@xgtFrmistatistik_tab_ap              : @xf-xgt_Frmistatistik_tab_ap;
@xgtFrmistatistik_tab_metin           : @xf-xgt_Frmistatistik_tab_metin;
@xgtFrmistatistik_tab_yan_sinir_renk  : @xf-xgt_Frmistatistik_tab_yan_sinir_renk;
//-- Aktif tab buton	
@xgtFrmistatistik_aktif_tab_ap        : @xf-xgt_Frmistatistik_aktif_tab_ap;
@xgtFrmistatistik_aktif_tab_metin     : @xf-xgt_Frmistatistik_aktif_tab_metin;
@xgtFrmistatistik_aktif_tab_sinir_renk: @xf-xgt_Frmistatistik_aktif_tab_sinir_renk;
//-- Sınır ve satırlar
@xgtFrmistatistik_sinir_renk          : @xf-xgt_Frmistatistik_sinir_renk;
@xgtFrmistatistik_icerik_satir1       : @xf-xgt_Frmistatistik_icerik_satir1;
@xgtFrmistatistik_icerik_satir2       : @xf-xgt_Frmistatistik_icerik_satir2;
//-- Mini header
@xgtFrmistatistik_altHeader_ap        : linear-gradient(0deg, @xf-xgt_Frmistatistik_altHeader_ap, mix(xf-intensify(@xf-xgt_Frmistatistik_altHeader_ap, 10%), @xf-xgt_Frmistatistik_altHeader_ap, 50%));
@xgtFrmistatistik_altHeader_metin     : @xf-xgt_Frmistatistik_altHeader_metin;
//-- Sıra numaraları
@xgtFrmistatistik_sira_ap             : @xf-xgt_Frmistatistik_sira_ap;
@xgtFrmistatistik_sira_metin          : @xf-xgt_Frmistatistik_sira_metin;
//-- Sayısal veriler
@xgtFrmistatistik_sayisal_veriler     : @xf-xgt_Frmistatistik_sayisal_veriler;
//-- Gövde yüksekligi
@xgtFrmIstatistik-maxYukseklik        : @xf-xgt_Frmistatistik_maxYukseklik;
//-- Global sutun genislikleri
@xgtFrmIstatistik-sira       : 25px;
@xgtFrmIstatistik-avatar     : 33px;
@xgtFrmIstatistik-konu       : 100%;
@xgtFrmIstatistik-forum      : 120px;	 
@xgtFrmIstatistik-cevap      : 70px;
@xgtFrmIstatistik-goruntuleme: 70px;
@xgtFrmIstatistik-zaman      : 90px;
@xgtFrmIstatistik-sonYazan   : 110px;
//-- Global LESS yapısı
body .xgtForumIstatistik {counter-reset: steps !important;}
html .xgtForumIstatistik ._xgtIstatistik--blok{
	&::-webkit-scrollbar-thumb {
		background: #858585;
		border-radius: 4px;
	}
	&::-moz-scrollbar-track {
		background: #858585;
		border-radius: 4px;
	}
}
html .xgtForumIstatistik ._xgtIstatistik--blok{
	';
	if ($__templater->func('property', array('xgt_Frmistatistik_srollbar', ), false) == 'gizle') {
		$__finalCompiled .= '
		scrollbar-width: none;
		&::-webkit-scrollbar { width: 0px;}
		&::-moz-scrollbar    { width: 0px;}
	';
	} else if ($__templater->func('property', array('xgt_Frmistatistik_srollbar', ), false) == 'goster') {
		$__finalCompiled .= '
		scrollbar-width: thin;
		&::-webkit-scrollbar{ width: 1px;}
		&::-moz-scrollbar   { width: 1px;}
	';
	}
	$__finalCompiled .= '
}
';
	if ($__templater->func('property', array('xgt_Frmistatistik_srollbar', ), false) == 'gizlegoster') {
		$__finalCompiled .= '
	html .xgtForumIstatistik ._xgtIstatistik--blok{
		scrollbar-width: none;
		&::-webkit-scrollbar{ width: 0px;}
		&::-moz-scrollbar   { width: 0px;}
		&:hover{
			scrollbar-width: thin;
			&::-webkit-scrollbar{ width: 1px;}
			&::-moz-scrollbar   { width: 1px;}
		}
	}
';
	}
	$__finalCompiled .= '	
.xgtForumIstatistik
{	
	margin: 5px 0;

	&-row
	{
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		flex-wrap: wrap;

		&--sag-s, 
		&--sol-s
		{
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_kullanici_veri_konum', ), false) == 'solda') {
		$__finalCompiled .= '
				flex: 0 0 20%;
				max-width: 20%;
			';
	} else {
		$__finalCompiled .= '
				flex: 0 0 19.7%;
				max-width: 19.7%;
				margin-left: 0.3%;
			';
	}
	$__finalCompiled .= '
		}
		&--l
		{
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_kullanici_veri_konum', ), false) == 'sagda') {
		$__finalCompiled .= '
				flex: 0 0 80%;
				max-width: 80%;
		    ';
	} else {
		$__finalCompiled .= '
				flex: 0 0 79.7%;
				max-width: 79.7%;
				margin-left: 0.3%;
		    ';
	}
	$__finalCompiled .= '
		}
		&--xl
		{
			flex: 0 0 100%;
			max-width: 100%;	
		}		
	}
	._xgtIstatistik--blok
	{
		max-height: @xgtFrmIstatistik-maxYukseklik;
		overflow-y: auto;
		border-radius: 0px 0px @xf-xgt_Frmistatistik_header_radius @xf-xgt_Frmistatistik_header_radius;
		
		.m-transition(all, -xf-height;);

		&.is-active
		{
			overflow: hidden;
			height: 0;
			opacity: 0;	
			
			.m-transition(all, -xf-height;);
		}
	}		
	.collapseTrigger
	{
		opacity: 0.5;
		transition: opacity 0.3s;
		margin-right: 5px;
		font-size: 22px;
		
		&:before{ content: "\\f205";}
		
		&.is-active:before
		{
			content: "\\f205";
			transform: scale(-1, 1);
		}
	}		
	.xgtForumIstatistik-tabHeader.block-tabHeader
	{
		background: @xgtFrmistatistik_tab_ap;
		color: @xgtFrmistatistik_tab_metin ;
		border-bottom: none;
		
		.tabs-tab
		{
			border-right: solid 1px @xgtFrmistatistik_tab_yan_sinir_renk;
			font-size: @xf-xgt_Frmistatistik_tab_metin_boyut;
			position: relative;
			
			&:not(.is-readonly):hover,
			&:hover
			{
				background: @xgtFrmistatistik_aktif_tab_ap;
				color: @xgtFrmistatistik_aktif_tab_metin;
			}
			
			&.is-active
			{
				background: @xgtFrmistatistik_aktif_tab_ap;
				color: @xgtFrmistatistik_aktif_tab_metin;
				border-color: @xgtFrmistatistik_aktif_tab_sinir_renk;
				border-right: solid 1px @xgtFrmistatistik_tab_yan_sinir_renk;
				
				&::after 
				{
					border-radius: 20px;
					content: "\\f357";
					color: @xgtFrmistatistik_aktif_tab_sinir_renk;
					display: inline-block;
					line-height: 15px;
					font-weight: 900;
					font-family: \'Font Awesome 5 Duotone\';
					bottom: -1px; left: 0; right: 0;
					margin: auto;
					position: absolute;
					overflow: hidden;
					width: 15px; height: 8px;
				}
			}
			//--- Kullanıcı alan tab ozelliklerini gizle
			&._userTabs
			{
				border-right: none;

				&:hover,
				&:not(.is-readonly):hover
				{
					background: none;
					color: inherit;
					cursor: text;
				}
			}
		}
	}
	._xgtIstatistik-konuListe
	{
		padding: 0;
		margin: 0;
		list-style: none;
	}
	
	&-tabHeader
	{
		position: relative;
		border-radius:@xf-xgt_Frmistatistik_header_radius @xf-xgt_Frmistatistik_header_radius 0px 0px;
		margin-bottom: 0;
		
		._collapseButton
		{
			position: absolute;
			right: 0;
			top: 0;
		}
	}
	._xgtIstatistik-satir
	{	
		display: table;
		font-size: @xf-xgt_Frmistatistik_metin_boyutu;
		table-layout: fixed;
		list-style: none;
		margin: 0;
		width: 100%;
		';
	if ($__templater->func('property', array('xgt_Frmistatistik_sinir_altSinirlar_etkin', ), false)) {
		$__finalCompiled .= '
			border-bottom: solid 1px @xgtFrmistatistik_sinir_renk;
		';
	}
	$__finalCompiled .= '
		//-- 2 1. row ap renk
		&:nth-child(1n)
		{ 
			background: @xgtFrmistatistik_icerik_satir1;
			';
	if (!$__templater->func('property', array('xgt_Frmistatistik_sinir_altSinirlar_etkin', ), false)) {
		$__finalCompiled .= '
				border-bottom: solid 1px @xgtFrmistatistik_icerik_satir1;
			';
	}
	$__finalCompiled .= '
		}
		
		//-- 2 2. row ap renk
		&:nth-child(2n)
		{ 
			background: @xgtFrmistatistik_icerik_satir2;
			';
	if (!$__templater->func('property', array('xgt_Frmistatistik_sinir_altSinirlar_etkin', ), false)) {
		$__finalCompiled .= '
				border-bottom: solid 1px @xgtFrmistatistik_icerik_satir2;
			';
	}
	$__finalCompiled .= '
		}
		
		&--hucre
		{
			display: table-cell;
			padding: @xf-xgt_Frmistatistik_icerik_satir_yukseklik 1px;
			text-overflow: ellipsis;
			overflow: hidden;
			vertical-align: top;
			white-space: nowrap;
			
			//-- Tum baglantilar
			a
			{
				color:@xgtFrmistatistik_baglantilar;
				&:hover{color:@xgtFrmistatistik_baglantilar-h;}
			}
		}
		
		&--sira
		{
			width: @xgtFrmIstatistik-sira;
			max-width: @xgtFrmIstatistik-sira;
			text-align: center;
			
			&._sayisal
			{			
				background: @xgtFrmistatistik_sira_ap;
				color: @xgtFrmistatistik_sira_metin;
				
				&::before
				{
					counter-increment: steps;
					content: "" counter(steps) "";
				}	
			}
		}

		&--avatar
		{
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
				width: @xgtFrmIstatistik-avatar;
				max-width: @xgtFrmIstatistik-avatar;
			';
	} else {
		$__finalCompiled .= '
				width: (@xgtFrmIstatistik-avatar)+5px;
				max-width: (@xgtFrmIstatistik-avatar)+5px;			
			';
	}
	$__finalCompiled .= '
			position: relative;
			text-align: center;
			//-- Cevrim ici, Dışı  tasarımı	
			&-offline,
			&-online 
			{
				border: solid 1px #fff;
				border-radius: 50px 50px 0px 50px;
				display: inline-block;
				width: 11px; height: 11px;
				position: absolute;
				content: \'\';
				';
	if ($__templater->func('property', array('xgt_Frmistatistik_sira_numarasi', ), false)) {
		$__finalCompiled .= '
					left: 0;
				';
	} else {
		$__finalCompiled .= '
					left: 2px;
				';
	}
	$__finalCompiled .= '
			}

			&-online  {background: #669933;}			
			&-offline {background: #e03030;}		
			
			.avatar
			{
				font-size: @xf-xgt_Frmistatistik_metin_boyutu;
				
				&.avatar--s
				{
					width: 25px; height: 25px;
					font-size: @xf-xgt_Frmistatistik_metin_boyutu;
					margin-top: -2px;
				}
			}

			._istatistikHucre_avatar 
			{
				font-size: @xf-xgt_Frmistatistik_metin_boyutu;
				position: absolute;
				width: 16px;height: 16px;
				right: 0; bottom: 0;
			}
		}
		
		&--konu
		{
			width: @xgtFrmIstatistik-konu;
			max-width: @xgtFrmIstatistik-konu;
			position: relative;

			//-- Okunmamis mesaj metin kalinlik
			&._yeniIcerik{ font-weight: 700; }
			
			//-- Google butonu
			._googleButon
			{
				background: #4285f4;
				color: #fff;
				display: inline-block;
				font-size: (@xf-xgt_Frmistatistik_metin_boyutu)-2px;
				padding: 0px 3px 1px 3px;
				border-radius: 5px;
				margin: 0 0 0 2px;
			}
		}
		
		&--forum
		{	
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false)) {
		$__finalCompiled .= '
				width: @xgtFrmIstatistik-forum;
				max-width: @xgtFrmIstatistik-forum;
			';
	} else {
		$__finalCompiled .= '
				width: (@xgtFrmIstatistik-forum)+100px;
				max-width: (@xgtFrmIstatistik-forum)+100px;
			';
	}
	$__finalCompiled .= '
			
			//-- Icerik bilgi ikonları
			._icerikIkonu
			{
				color: #979797;
				display: inline-block;
				margin-right: 3px;	
				
				&--cozuldu {color: @xf-xgt_Frmistatistik_cozumIkon_renk;}
				&--soru    {color: @xf-xgt_Frmistatistik_soruIkon_renk;}
				&--konu    {color: @xf-xgt_Frmistatistik_konuIkon_renk;}
				&--makale  {color: @xf-xgt_Frmistatistik_makaleIkon_renk;}
				&--anket   {color: @xf-xgt_Frmistatistik_anketIkon_renk;}
				&--kaynak  {color: @xf-xgt_Frmistatistik_kaynakIkon_renk;}
			}
		}
		
		&--cevap
		{
			width: @xgtFrmIstatistik-cevap;
			max-width: @xgtFrmIstatistik-cevap;
		}
		
		&--goruntuleme
		{
			width: @xgtFrmIstatistik-goruntuleme;
			max-width: @xgtFrmIstatistik-goruntuleme;
		}
		
		&--zaman
		{
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false)) {
		$__finalCompiled .= '
				width: @xgtFrmIstatistik-zaman;
				max-width: @xgtFrmIstatistik-zaman;	
			';
	} else {
		$__finalCompiled .= '
				width: (@xgtFrmIstatistik-zaman)+20px;
				max-width: (@xgtFrmIstatistik-zaman)+20px;
			';
	}
	$__finalCompiled .= '
		}
		
		&--sonYazan
		{	
			padding-left: 5px;	
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_kullanici_verisi', ), false)) {
		$__finalCompiled .= '
				width: @xgtFrmIstatistik-sonYazan;
				max-width: @xgtFrmIstatistik-sonYazan;			
			';
	} else {
		$__finalCompiled .= '
				width: (@xgtFrmIstatistik-sonYazan)+20px;
				max-width: (@xgtFrmIstatistik-sonYazan)+20px;
			';
	}
	$__finalCompiled .= '
		}
		&--derece
		{
			width: @xgtFrmIstatistik-cevap + @xgtFrmIstatistik-goruntuleme;
			max-width: @xgtFrmIstatistik-cevap + @xgtFrmIstatistik-goruntuleme;
		}
		&--sira, &--cevap, &--goruntuleme
		{
			color:@xgtFrmistatistik_sayisal_veriler;
			cursor: help;
		}
		&--cevap, &--goruntuleme, &--zaman, &--derece {text-align: center;}
		&--forum, &--cevap, &--goruntuleme, &--zaman, &--sonYazan, &--derece
		{
			padding-left: 4px;
			padding-right: 2px;
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_sinir_yanSinirlar_etkin', ), false)) {
		$__finalCompiled .= '
				border-left:solid 1px @xgtFrmistatistik_sinir_renk;
			';
	}
	$__finalCompiled .= '
			';
	if ($__templater->func('property', array('xgt_Frmistatistik_altHeader_metinAlani', ), false) == 'ikon') {
		$__finalCompiled .= '
				text-align: center;	
			';
	}
	$__finalCompiled .= '
		}
		
		//-- Mini header
		&._xgtIstatistik_miniHeader 
		{
			background: @xgtFrmistatistik_altHeader_ap;
			color: @xgtFrmistatistik_altHeader_metin;
			border-bottom:none;

			i{ margin-right: 5px; }

			._xgtIstatistik-satir
			{
				&--sira, &--forum, &--cevap, &--goruntuleme, &--zaman, &--sonYazan, &--derece
				{
					color: @xgtFrmistatistik_altHeader_metin;
					border-left: none;
					text-align: center;
				}
				&--konu { padding-left:5px; }
			}
		}	
	}
	//---- Istatistik yukleniyor ikon
	._istatistikYukleniyor
	{
		font-size: 100px;
		text-align: center;
		color: @xgtFrmistatistik_aktif_tab_sinir_renk;
		height: 100%; width: 100%;
		display: inline-block;
		margin-top:100px;
	}
	//-- Çözünürlük sınırları
	@media (max-width: @xf-responsiveWide){
		.xgtForumIstatistik-row--sol-s, 
		.xgtForumIstatistik-row--sag-s {display:none;}
		.xgtForumIstatistik-row--l{
			flex: 100%;
			max-width: 100%;
		}
	}
	@media (max-width: 800px){
		._xgtIstatistik-satir--zaman, 
		.collapseTrigger,
		._xgtIstatistik-satir--sira {display:none;}		
	}
	@media (max-width: 700px){
		._xgtIstatistik-satir--cevap,
		._xgtIstatistik-satir--goruntuleme {display:none;}		
	}
	@media (max-width: 600px){
		._xgtIstatistik-satir--sonYazan {display:none;}		
	}
	@media (max-width: 500px){
		._xgtIstatistik-satir--sabitKonu,
		._xgtIstatistik-satir--forum {display:none;}		
	}
	.hScroller-action.hScroller-action--end { z-index: 9; }
}';
	return $__finalCompiled;
}
);