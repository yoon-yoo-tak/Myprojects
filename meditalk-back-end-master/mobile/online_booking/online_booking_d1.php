<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <style>
	#area-box{
		width:100%;
		margin:0 auto;
	}
	.search-box{
		width:94%;
		height:30px;
    
		border-radius:10px;
		background:rgb(230,230,230);
		margin:0 auto;
		position:relative;

	}
	.search-box img {
		padding-left:10px;
		padding-top:7px;
	}
	.search-box input{
		width:80%;
		height:20px;
		border:0px;
		background:rgb(230,230,230);	
		padding-left:10px;
		position:absolute;
		top:4px;
	}
	.search-box input:focus { outline: none; }
	#map{
		width:100%;
		height:81vh;		
		margin-top:10px;
	}
	ul{
		margin:0;
		padding:0;
		list-style:none;
	}
    .item{
        width:100vw;
        height:14vh;
        border-bottom:1px solid rgb(194,194,194);
        margin-bottom:10px;
    }
    .bottom-btn{
        height:7vh;
        line-height:7vh;
    }
    .bm-btn-last{
        margin-right:6vw;
    }
    .item-info{
        margin-left:6vw;
    }
    .item h4,.item span
    {
        color:rgb(52,68,110);
    }
    i{
        color:rgb(52,68,110);
    }
    </style>
</head>
<body>
    
    <?php
        $con = mysqli_connect("localhost","meditalk","huiyih135!","meditalk");
        $query = "SELECT * FROM Hospital";
        $result = mysqli_query($con,$query);
        $arr = array();
        
        while($row = mysqli_fetch_array($result))
            $arr[$row['hp_id']]=array($row['hp_name'],$row['hp_lat'],$row['hp_lng'],$row['hp_addr'],$row['hp_admin_phone']);
        
        $from_search_hpid    = mysqli_real_escape_string($con,$_POST['from_search_hpid']);
        $from_search_arr;
        
        if($from_search_hpid){
            $from_obj = mysqli_fetch_array(mysqli_query($con,"
                                    SELECT * FROM Hospital WHERE hp_id='$from_search_hpid'
                                "));
            $from_search_arr['hp_lat']  = $from_obj['hp_lat'];
            $from_search_arr['hp_lng']  = $from_obj['hp_lng'];
            
        }
    ?>
    <input type="hidden" id="from-search-hpid" value="<?=$from_search_hpid?>">
    <div width="97%" style="margin-bottom:4%; margin-left:3%;">
        <img src="img/left.png" onclick="back();">
        <div class="text-right" style="display:inline-block; width:83%; margin-right:3%;">
            <i id='search-hospital-btn' class="glyphicon glyphicon-search" style="font-size:20px; display:inline;" onclick="searchPage();"></i>
        </div>    
    </div>
   <div id="area-box" >
    <!--<div class="search-box">
	        <img src="img/search.png">
            <input type="text" placeholder="검색어를 입력하세요.">	
    
	    </div>-->
	<div class="text-center" style="margin-top:10px;">
		<span style="color:rgb(52,68,110); font-size:16px;" id="addr_btn"></span>
		<i class="glyphicon glyphicon-chevron-down" style="font-size:16px;" id="addr_icon"></i>
	</div>
    <!--다음 지도 -->
    <div id="map"></div>
	<div class="text-center" style="margin-top:10px;">
		<span style="color:rgb(52,68,110);font-size:16px;" id="near_hp_btn">가까운 병원 보기</span>
		<i class="glyphicon glyphicon-chevron-up" style="font-size:16px;" id="near_hp_icon"></i>
	</div>
	<ul class="hospital_list" style="display:none;">
        <!-- <li class="item">
            <div class='item-info'>
                <h4>메디톡 병원</h4>
                <img src='img/placeholder.png'>
                <span>516m</span>
                <span style='color:rgb(153,161,182);'>|</span>
                <span style='color:rgb(153,161,182);'>충청북도 청주시 청원구 안덕벌로 40</span>
            </div>
            <div class='text-right bottom-btn'>
                <span>온라인 예약</span>
                <span style='color:rgb(153,161,182);'>|</span>
                <span class='bm-btn-last'>전화</span>
            </div>

        </li> -->
	</ul>

    </div>

    <script src="//dapi.kakao.com/v2/maps/sdk.js?appkey=e4b699f06f6b261985ab9174828c3fa4&libraries=services"></script>
    <script type="text/javascript">
        //검색 아이콘 클릭시
        function searchPage(){
            window.location.href="search_hospital.html";
        }
        var infowindow ;
        function back(){
            window.android.back();
        }
        var hospital = <?=json_encode($arr,JSON_UNESCAPED_UNICODE)?>;

        //var lat = window.android.getLat();
        //var lng = window.android.getLng();
        var lat = 36.6521308;
        var lng = 127.4945351;
        var geocoder = new daum.maps.services.Geocoder();
        var position = new daum.maps.LatLng(lat,lng);
        //var position = new daum.maps.LatLng(36.65085651,127.49519712);
        // 검색 페이지에서 이동해서 오면
        if($("#from-search-hpid").val() != ""){
            var from_search_hp = <?=json_encode($from_search_arr,JSON_UNESCAPED_UNICODE)?>;
            position = new daum.maps.LatLng(parseFloat(from_search_hp['hp_lat']),parseFloat(from_search_hp['hp_lng']));
        }
        
        var map = new daum.maps.Map(document.getElementById('map'),
                                    {
                                     center: position,
                                     level:5
                                    }
                                    );
        
       
        var callback = function(result, status) {
            if (status === daum.maps.services.Status.OK) {
                var index;
                var addr = result[0].address.address_name;
                if(addr.lastIndexOf("읍") != -1)
                    index=addr.lastIndexOf("읍");
                else if(addr.lastIndexOf("면") != -1)
                    index=addr.lastIndexOf("면");
                else
                    index=addr.lastIndexOf("동");
                

                $("#addr_btn").text(addr.substring(0,index+1));
            }
        };
        geocoder.coord2Address(position.getLng(),position.getLat(), callback);
        
         for(var key in hospital){
             var hp_name = hospital[key][0];
             var hp_lat = hospital[key][1];
             var hp_lng = hospital[key][2];
             var hp_addr = hospital[key][3];
             var hp_tel = hospital[key][4];
             
	         var marker = new daum.maps.Marker({ 
                 position: new daum.maps.LatLng(hp_lat, hp_lng),
                 map: map,
                 clickable: true ,
                 }); 
            
            var distance = window.android.distance(hp_lat, hp_lng);      
            
            if(distance <= 1000){
                var el = $("<li class=item>\
                                    <div class='item-info'>\
                                        <h4>"+hp_name+"</h4>\
                                        <img src='img/placeholder.png'>\
                                        <span>"+distance+"m</span>\
                                        <span style='color:rgb(153,161,182);'>|</span>\
                                        <span style='color:rgb(153,161,182);'>"+hp_addr+"</span>\
                                    </div>\
                                    <div class='text-right bottom-btn'>\
                                        <form action='online_booking_date.php' method='POST'>\
                                            <input type='hidden' value="+key+" name='hp_pk'>\
                                        </form>\
                                        <span class='online_booking'>온라인 예약</span>\
                                        <span style='color:rgb(153,161,182);'>|</span>\
                                        <span class='bm-btn-last'>전화</span>\
                                    </div>\
                            </li>");
                $(".hospital_list").append(el);            
            }     
            // 마커를 클릭했을 때 마커 위에 표시할 인포윈도우를 생성합니다
             // 인포윈도우에 표출될 내용으로 HTML 문자열이나 document element가 가능합니다
            
            

            makeClickInfo(hp_name,distance,hp_addr,key,hp_tel);
             
         }
         
         function makeClick(map, marker, infowindow) {
            return function() {
                infowindow.open(map, marker);
            };
        }
        //마커 클릭시 정보 생성
        function makeClickInfo(hp_name,distance,hp_addr,key,hp_tel){
            var dis;
             if(distance >= 1000){
                 dis=(parseInt(distance/1000))+"km";
            } else{
                dis=distance+"m";
            }
            var iwContent = "\
                            <div class='item-info'>\
                                <h4>"+hp_name+"</h4>\
                                <img src='img/placeholder.png'>\
                                <span>"+dis+"</span>\
                                <span style='color:rgb(153,161,182);'>|</span>\
                                <span style='color:rgb(153,161,182);'>"+hp_addr+"</span>\
                            </div>\
                            <div class='text-right bottom-btn'>\
                                <form action='online_booking_date.php' method='POST'>\
                                    <input type='hidden' value="+key+" name='hp_pk'>\
                                </form>\
                                <span class='online_booking' style='color:rgb(52,68,110);'>온라인 예약</span>\
                                <span style='color:rgb(153,161,182);'>|</span>\
                                <span class='bm-btn-last tel' style='color:rgb(52,68,110);'>전화</span>\
                                <input type='hidden'  value="+hp_tel+">\
                            </div><br>\
                            ";
            
             // 인포윈도우를 생성합니다
             infowindow = new kakao.maps.InfoWindow({
                content : iwContent,
                removable : true
            });
         
            kakao.maps.event.addListener(marker, 'click',makeClick(map,marker,infowindow));
        }
         //주소 클릭시
        $("#addr_btn").click(function(){
            $("#map").css("display","block");
            $(".hospital_list").css("display","none");
            $("#addr_icon").attr('class','glyphicon glyphicon-chevron-down');
            $("#near_hp_icon").attr('class','glyphicon glyphicon-chevron-up');
        });
        // 가까운 병원보기 클릭시
        $("#near_hp_btn").click(function(){
            $("#map").css("display","none");
            $(".hospital_list").css("display","block");
            $("#near_hp_icon").attr('class','glyphicon glyphicon-chevron-down');
            $("#addr_icon").attr('class','glyphicon glyphicon-chevron-up');
        });
      
        //온라인 예약 클릭시
        $(document).on("click",".online_booking",function(){
            $(this).prev("form").submit();
        });
        $(document).on("click",".tel",function(){
            
            var tel = $(this).next("input").val();
            window.android.callPhone(tel);
        });
    </script>
</body>
</html>