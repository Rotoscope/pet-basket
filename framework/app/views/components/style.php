<style>
    html,
    body {
        overflow-x: hidden; /* Prevent scroll on narrow devices */
    }

    body {
        padding-top:90px;
        height:100%;
        padding-bottom: 70px;
    }

    .wrap {
        min-height: 100%;
        height: auto;
        /* Negative indent footer by its height */
        margin: 0 auto -80px;
        /* Pad bottom by footer height */
        padding: 0 0 80px;
    }

    .main{
        min-height: 600px;
    }

    .header{
        width: 100%;
    }

    .footer {
        width: 100%;
        /* Set the fixed height of the footer here */
        //height: 30px;
    }

    /*    .header span{
            color: #FFFFFF;
            padding-top:10px;
            padding-left:20px;
            font-size:25px;
        }*/

    /*  PET BASKET MODAL */
    #petbasketModal img {
        width: 80px;
        /*height: 80px;*/
    }
    
    .petBasketButton {
        width: 76px;
        height: 34px;
        padding: 0px;
    }
    
    .petBasketModalPetName{
        margin-top: 0px;
        font-weight: 700;
    }


    .font-size-120-p {
        font-size: 120%;
    }
    
    .font-size-140-p {
        font-size: 140%;
    }
    
    .font-size-160-p {
        font-size: 160%;
    }


    /* HEADER */
    .loginGroup {
        /*display: inline-block;*/
        width: 30%;
        float: right; 
    }
    
    .loginGroup .petBasketBtn{
        display:inline;
        float: left;
        width: 30%;
        padding-top: 3%;
        padding-left:30%;
    }
    
    .loginGroup .petBasketBtn img{
        width:35px;
        height:20px;
    }
    
    .loginGroup .hiddenMenu{
        display:inline;
        float: right;
        width: 30%;
        padding-top: 3%;
        padding-right: 45%;
    }
    
    .caret{
        color: grey;
        font-size:30px;
    }
    
    .userNav {
        width:50%;
    }

    /*
     * change the size of modal
     * --------------------------------------------------
     */
    #modalHeader{
        text-align: center;
    }

    .modalSeperator{
        border-left: dotted;
        border-left-width: 1px;
        border-left-color: grey;
    }

    @media screen and (min-width: 300px) {
        #loginModal .modal-dialog  {width:60%;}
        #contactModal .modal-dialog  {width:50%;}
        #petbasketModal .modal-dialog  {width:50%;}
    }

    /*
     * change the position of the modal
     * --------------------------------------------------
     */
    #contactModal { 
        top:10%;
        right:10%;
        left:10%;
        outline: none;
    }

    /*
    * petbasketModal
    * --------------------------------------------------
    */
    #petbasketModal .pb-footer p{
        display: inline;
        float:left;
        font-size: 18px;
        padding-top:15px;
    }

    #petbasketModal .pb-footer button{
        width:30%;
        display: inline;
        font-size: 18px;
    }

    /*
     * petbasketModal slide in from right
     */
    #petbasketModal.fade:not(.in).slideright .modal-dialog {
        -webkit-transform: translate3d(25%, 0, 0);
        transform: translate3d(25%, 0, 0);
    }

    /*
     * Petbasket home page
     * --------------------------------------------------
     */
    #home .item {
        border: 1px solid #cecece;
        padding: 12px 6px;
        background: #ededed;
        background: -webkit-gradient(linear, left top, left bottom,color-stop(0%, #f4f4f4), color-stop(100%, #ededed));
        background: -moz-linear-gradient(top, #f4f4f4 0%, #ededed 100%);
        background: -ms-linear-gradient(top, #f4f4f4 0%, #ededed 100%);
        margin-top: 2%;
    }

    #home img{
        width:100%;
        height:auto;
    }

    /*
     * Off Canvas
     * --------------------------------------------------
     */
    @media screen and (max-width: 767px) {
        .row-offcanvas {
            position: relative;
            -webkit-transition: all .25s ease-out;
            -o-transition: all .25s ease-out;
            transition: all .25s ease-out;
        }

        .row-offcanvas-right {
            right: 0;
        }

        .row-offcanvas-left {
            left: 0;
        }

        .row-offcanvas-right
        .sidebar-offcanvas {
            right: -50%; /* 6 columns */
        }

        .row-offcanvas-left
        .sidebar-offcanvas {
            left: -50%; /* 6 columns */
        }

        .row-offcanvas-right.active {
            right: 50%; /* 6 columns */
        }

        .row-offcanvas-left.active {
            left: 50%; /* 6 columns */
        }

        .sidebar-offcanvas {
            position: absolute;
            top: 0;
            width: 50%; /* 6 columns */
        }
    }

    .top-bottom-20 {
        padding-top: 20px;
        padding-bottom: 20px;
    }

    .top-20 {
        padding-top: 20px;
    }

    .mtop-20 {
        margin-top : 20px;
    }

    .m-top-70 {
        margin-top: 70px;
    }

    .m-bottom-60 {
        margin-bottom: 60px;
    }

    .m-bottom-10 {
        margin-bottom: 10px;
    }

    .bottom-20 {
        padding-bottom: 20px;
    }

    .p-top-60 {
        padding-top: 60px;
    }

    .p-bottom-60 {
        padding-bottom: 60px;
    }

    .fr {
        float: right;
    }

    .fl {
        float: left;
    }

    .m-l-2p {
        margin-left: 2%;
    }

    .m-l-1p {
        margin-left: 1%;
    }

    .hide{
        visibility: hidden;
    }

    .displayNone{
        display: none;
    }

    /* HOME PAGE */
    .homeImage {
        min-height: 220px;
        max-height: 220px;
    }


    /* BROWSE PAGE */
    .petPanel {
        margin-top: 1%;
    }
    
    .petTileRow {
        padding-top: 1%;
        padding-bottom: 1%;
    }
    
    .petTileRowLabel {
        font-weight: 700;
        font-style: italic;
    }
    
    .pagingWidget {
        position: fixed;
        bottom: 12px;
        right: 2%;
        z-index: 3;
    }
    
    .pagingWidgetTextSpan {
        color: white;
    }

    .petTileExpansion {
        margin-top: 15px;
    }
    
    .petTileExpansionButton {
        margin-top: 15px;
        border-top: 1px solid;
        border-top-color: #ddd;
        padding: 6px;
    }
    
    .panelBodyCustom {
        padding-bottom: 0px;
    }

    .navbarOverride{
        height: 54px;
        //margin:0px;
    }

    .navigationRow{
        padding-top: 5%;
        margin-bottom: 0px;
    }

    .navigationRowOverride{
        transform: translate(0px, -64px);
    }

    .navOverrideContactPoster {
        margin-top: 54px;
    }


    .topPaddingFourPercent {
        padding-top: 4%;
    }

    .topPaddingTwoPercent {
        padding-top: 2%;
    }

    .borderOnePixelSolid {
        border: 1px solid;
        border-color: "black";
    }

    .bodyRowBox{
        border-left: 1px solid gray;
        border-right: 1px solid gray;
        border-bottom: 1px solid gray;
    }

    .noSideMargins{
        position: relative;
        height: 100%;
        padding-left: 0px;
        padding-right: 0px;
        margin-left: 0px;
        margin-right: 0px;
        width: 100%;
    }

    .browseBody {
        position: relative;
        height: 100%;
    }

    .browsePageBodyRow{       
        height: 100%;
        padding-top: 50px;
        margin-left: 0px;
        margin-right: 0px;       
    }

    .waterFallRow{
        width: 98%;
        padding: 1%;
        margin: 1%;
        border: 3px solid;
        border-color: #269abc;
    }
    .waterFallColumn{
        padding-left: 0%;
        padding-right: 0%;
        /*height: 100%;*/
    }

    .submitLabel {
        font-weight: 700;
        position: relative;
        top: -10px;
    }

    .description {
        text-align: center;
        font-weight: 700;
        font-size: 120%;
    }

    .petName {
        font-size: 150%;
        font-weight: 700;
    }
    
    /* FILTER */
    .filter {
        /*height:100%;*/
        padding-top: 1%;
        padding-left: 3%;
        padding-right: 2%;
        margin-top: 0px;
    }

    .filterRow {
        padding: 10px;
    }

    #filterLabel {
        font-size: 140%;
    }

    .filterButton {
        margin-top: 1px;
    }
    /* END FILTER */



    .petDescription{
        text-wrap: normal;
        font-size: 120%;
    }

    .petImage{
        //width:100%;
        max-width: 200px; 
        max-height: 200px;
    }

    .loggedInUsername {
        float: left;
        display: inline;
        width: 50%;
        margin-right: 0px;
        font-size: 120%;
        padding: 10px;
        color: #ffffff;
    }


    .loginButton {
        float: left;
    }

    .thumbnail .captionBox {
        padding-bottom: 25%;
    }

    .desc{
        display: inline-block;
        float: left;
        margin-left: 5%;
    }
    .adoptBtn{
        float: right;
        padding: 5%;
    }

    .petBasketImage {
        padding: 0px;
        height: 30px;
    }

    .customNavBarBrand{
        float: right;
        color: #eee !important;
        font-size:150%;
    }
    .customNavBarBrand:hover{
        color: #CCC !important; 
    }


    /******* FOOTER CSS STYLES****/    
    .footer{ 
        background: #1D1D1D; 
        color: #eee;
        padding-left: 4%;
        z-index: 2;
    }

    #footer {
        background-color: #1D1D1D;
        color: #9d9d9d;
        width: 100%; 
        height: 51px;
        //position:absolute;
        bottom: 0;
        left: 0;
        margin-top: 20px;
        padding-top: 10px;
    }    

    #wrapper {
        min-height: 100%;
        position: relative;
    }

    #content {
        padding-bottom: 51px;   /* Height of the footer element */
    }

    .lightLabel{
        font-size: 10px;
        color: grey;
    }

    .loginSubmit {
        width: 80%;
        margin-top: 15px;
        margin-left: 10%;
    }
    .sendMessage {
        width: 50%;
        margin-top: 15px;
        margin-left: 25%;
    }

    .soloNav{
        margin-bottom: 20px; 
        padding: 0px
    }
    /*********** myPets Page ***********/
    .mainContent{
        width:80%;
        margin: auto;
    }
    /*********** Details Pet Page ***********/
    .imageContainer{
        width: 100%;
        height: 420px;
        background: #181515;
    }
    .dog-details{
        margin: 0 1.9em .75em 0;
        padding: .5em 1em;
        border: 1px solid #EEE;
        border-radius: 3px;
        background: #FAFAFA;
    }

    .dog-details li{
        color: #555;
    }

    .textwidget{
	   margin-top: 50px;
    }

    .textwidget button{
        position: relative;
        width: 100%;
        margin: 0 0 .75em;
        padding: 16px 15px 17px;
        background: #0089e0;
        color: #fff;
        border-radius: 3px 0 0 3px;
        font-size: 1.1em;
        text-align: left;
        letter-spacing: 2px;
        line-height: 1.5;
    }

    .textwidget button .point {
        content: "";
        position: absolute;
        display: inline-block;
        width: 0;
        height: 0;
        left: 100%;
        top: 0;
        border-style: solid;
        border-width: 30px 0 30px 16px;
        border-color: transparent transparent transparent #00C4BD;
        -webkit-transition: all .1s linear;
           -moz-transition: all .1s linear;
            -ms-transition: all .1s linear;
             -o-transition: all .1s linear;
                transition: all .1s linear;
    }

    .detail-box{
        min-height: 300px;
    }

    .tags{
        margin: 0;
        padding: 0;
        position: absolute;

        list-style: none;
    }

    .tags li, .tags a{
        float: left;
        height: 24px;
        line-height: 24px;
        position: relative;
        font-size: 11px;
    }

    .tags a{
        margin-left: 15px;
        padding: 0px 10px 0 12px;
        background: #0089e0;
        color: #fff;
        text-decoration: none;
        -moz-border-radius-bottomright: 4px;
        -webkit-border-bottom-right-radius: 4px; 
        border-bottom-right-radius: 4px;
        -moz-border-radius-topright: 4px;
        -webkit-border-top-right-radius: 4px;    
        border-top-right-radius: 4px;    
    } 

    .tags a:before{
        content: "";
        float: left;
        position: absolute;
        top: 0;
        left: -12px;
        width: 0;
        height: 0;
        border-color: transparent #0089e0 transparent transparent;
        border-style: solid;
        border-width: 12px 12px 12px 0;      
    }

    .tags a:after{
        content: "";
        position: absolute;
        top: 10px;
        left: 0;
        float: left;
        width: 4px;
        height: 4px;
        -moz-border-radius: 2px;
        -webkit-border-radius: 2px;
        border-radius: 2px;
        background: #fff;
        -moz-box-shadow: -1px -1px 2px #004977;
        -webkit-box-shadow: -1px -1px 2px #004977;
        box-shadow: -1px -1px 2px #004977;
    }

    .tags a:hover{
	background: #555;
    } 

    .tags a:hover:before{
        border-color: transparent #555 transparent transparent;
    }

    .detailsImage {
        margin-top: 10px;
        height:400px;
        max-width: 550px;
        width:auto;
    }

    .detailsButtonRow {
        margin-left: auto;
        margin-right: auto;
    }

    .detailsButton {
        float: right;
        margin: 10px;
    }

    .detailsDescription {
        margin-left: 15px;
        margin-right: auto;
    }

    .detailsText {
        font-size: 120%;
    }

    /*********ADMIN********/
    .adminRow{
        margin-top: 10px;
        margin-bottom: 10px;
        border: 1px;
        border-style: solid;
        //height: 151px;
        //padding-top: 10px;
        //padding-bottom:10px;

    }

    #adminNewStyle{
        //background-color: #FF7F50;
    }

    #adminAllStyle{
        background-color: #99CCCC;  
    }

    .adminRowElement{
        border: 0px;
        position: relative;
        border-style: solid;
        height: 100%;
    }

    .adminThumbnail{
        max-width: 150px;
        max-height: 150px;
    }

    .adminButtons{
        margin-top: 3px;
        width: 80px;
        padding-top: 30px;
        padding-bottom: 30px;
    }

    .replyBox{
        padding:0px;
    }


    /*  contactUpdate   */
    .contactTile {
        border-style: solid; 
        border-width: 1px;
    }

    .contactTitleBox{
        margin: 0 1.9em .75em 0;
        padding: .5em 1em;
        border: 1px solid #EEE;
        border-radius: 3px;
        background: #FAFAFA;
    }

    /*  notification  */
    .notificationMessageHeader {
        font-size: 30px; 
        float: left; 
        padding-bottom: 2%; 
        margin-top: 1%;

    }
    /*  notification  */
    .notificationMessageNoNew {
        font-size: 30px; 
        float: left; 
        padding-bottom: 2%; 
        margin-top: 1%;
        float: right;
    }

    /*  aboutUs  */
    .aboutUsLabel {
        font-size: 20px; 
        float: left; 
        padding-bottom: 2%;
        padding-top: 2%;        
    }

    /*  myPets  */
    .newButton {
        margin-bottom: 60px; 
        padding-top: 70px
    }

    /* CONTACT POSTER MODAL */
    #contactPosterModalMessageNotification {
        float: left;
    }

    input:required:focus {
        border: 1px solid red;
        outline: none;
    }
    
    .tags > li {
        padding-top: 15px;
        margin-top: 15px;
    }
    
    
    .emailUpdateMsgSpan {
        padding-left:40px;
    }
</style>

