<?php
// FROM HASH: d8a91ae68e31c855f55f218aabb95d4d
return array(
'code' => function($__templater, array $__vars, $__extensions = null)
{
	$__finalCompiled = '';
	$__finalCompiled .= '#accountTypes {
  text-align: center;
  -webkit-transition: all 0.3s ease-in-out;
  transition: all 0.3s ease-in-out;
}

.accountTypesRow {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  /* align-items: center;*/
  justify-content: center;
}

.accountType {
  -webkit-box-flex: 1;
      -ms-flex: 1;
          flex: 1;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  margin: 10px 1%;
  font-family: \'Lato\', Arial, sans-serif;
  max-width: 325px;
}

.accountType-inner {
  -webkit-box-flex: 1;
      -ms-flex: 1;
          flex: 1;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;

  background: #fff;
  margin: 0 auto;
  width: 100%;
  position:relative;

  .btn {
    padding: 2em 0;
    text-align: center;

    a {
      background: #323232;
      padding: 10px 5%;
      color: #fff;
      text-transform: uppercase;
      font-weight: 700;
      text-decoration: none
    }

    a:hover {
      -webkit-box-shadow: 0px 0px 19px -3px rgba(0,0,0,0.7);
              box-shadow: 0px 0px 19px -3px rgba(0,0,0,0.7);
    }
  }


  .featured {
      position: absolute;
      top: -7px;
      background: #F80;
      color: #fff;
      text-transform: uppercase;
      z-index: 2;
      padding: 2px 5px;
      font-size: 9px;
      border-radius: 2px;
      right: 10px;
      font-weight: 700;
  }
}

.accountType-title {
  background: #53CFE9;
  height: 140px;
  position: relative;
  text-align: center;
  color: #fff;
  margin-bottom: 30px;

  > h3 {
    background: #20BADA;
    font-size: 20px;
    padding: 5px 0;
    text-transform: uppercase;
    font-weight: 700;
    margin: 0;
  }

  .priceContainer {
    position: absolute;
    bottom: -25px;
    background: #20BADA;
    height: 105px;
    width: 105px;
    margin: 0 auto;
    left: 0;
    right: 0;
    overflow: hidden;
    border-radius: 50px;
    border: 5px solid #fff;
    /* line-height: 80px;*/
    font-size: 28px;
    font-weight: 700;

    .price {
      top: 50%;
      left: 50%;
      position: absolute;
      -webkit-transform: translate(-50%, -50%);
              transform: translate(-50%, -50%);

      .customAmount {
        font-size: 12px;
      }

      .duration {
        /* position: absolute;*/
        font-size: 9px;
        /* bottom: -10px;*/
        /* left: 30px;*/
        text-transform: uppercase;
        font-weight: 400;
      }
    }

    &.customAmount .price {
      font-size: 16px;
      line-height: 17px;

      .duration {
        line-height: 12px;
        margin-top: 5px;
      }
    }

  }
}

.accountType-content {
  -webkit-box-flex: 1;
      -ms-flex: 1 0 auto;
          flex: 1 0 auto;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
      -ms-flex-direction: column;
          flex-direction: column;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;

  color: #323232;

  ul {
    margin: 0;
    padding: 0;
    list-style: none;
    text-align: center;
  }
  li {
    border-bottom: 1px solid #E5E5E5;
    padding: 10px 0;
  }

  li:last-child {
    border: none;
  }
}


@media (max-width: @xf-responsiveWide)
{
  .accountType {
    width: 100%;
    margin-left: auto !important;
    margin-right: auto !important;
    -webkit-box-flex: 0;
        -ms-flex: none;
            flex: none;
  }
  .accountType-inner {
    width: 65%;
  }
}

@media (max-width: @xf-responsiveNarrow)
{
  .accountType-inner {
    width: 80%;
  }
}

@media (min-width: (@xf-responsiveWide + 1px)) and (max-width: 1060px)
{
  html[data-template="af_paidregistrations_accounttype_member"] .p-body-main.p-body-main--withSidebar.p-body-main--withSideNav .accountType-inner > .btn > a
  {
      padding: 1% 1%;
  }
}

';
	return $__finalCompiled;
}
);