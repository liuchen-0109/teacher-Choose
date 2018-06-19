//定义地图，标记数组
var map,markersArray = [];
var init = function(id) {
    //设置地图中心点
    var center = new qq.maps.LatLng(39.916527,116.397128);
    map = new qq.maps.Map(document.getElementById('container'),{
        center: center,
        zoom: 12,
        scaleControl: false,
        zoomControl: false,
        panControl: false,
    });
    //添加dom监听事件
    qq.maps.event.addDomListener(map, 'click', function(event) {
        console.log(12)
        deleteOverlays();
        addMarker(event.latLng);
        $("input[name='lat']").val(event.latLng.getLat());
        $("input[name='lng']").val(event.latLng.getLng());

    });

    var geolocation = new qq.maps.Geolocation('CTABZ-P4QWU-HMQVH-2KDYB-RR7L7-XKFUM', 'admin');
    geolocation.getLocation(showPosition, showErr,);


    //精确定位成功
    function showPosition(position) {
        map.panTo(new qq.maps.LatLng(position.lat,position.lng))
        addMarker(new qq.maps.LatLng(position.lat,position.lng))
    }

    //精确定位失败时使用地址定位
    function showErr(){
        var citylocation = new qq.maps.CityService({
            complete : function(results){
                map.setCenter(results.detail.latLng);
                marker = new qq.maps.Marker({
                    map: map,
                    position: results.detail.latLng
                });
            }
        });
        citylocation.searchCityByName('郑州');
    }


}

//增加标记
function addMarker(location) {
    var marker = new qq.maps.Marker({
        position: location,
        map: map,
    });
    markersArray.push(marker);
}

//删除标记
function deleteOverlays() {
    if (markersArray) {
        for (i in markersArray) {
            markersArray[i].setMap(null);
        }
        markersArray.length = 0;
    }
}