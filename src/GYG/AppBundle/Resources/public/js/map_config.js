(function() {    var startOption = {        initLat: 581647.9745650819,        initLong: 5813280.860704543,        initZoom: 17,        editable: true,        drawType: DrawOnMap.drawingOptions.polygon,        singleDrawMode: false    };    var map;    var drawingOverlay;    drawingOverlay = DrawOnMap.initialize(startOption, map);    DrawOnMap.setData(drawingOverlay, '{"type":"FeatureCollection","features":[{"type":"Feature","geometry":{"type":"Polygon","coordinates":[[[894734.0424211621,3915196.5743270367],[-14133397.214670777,8298401.524312191],[-16951171.825375512,2975938.3707587942],[894734.0424211621,3915196.5743270367]]]},"properties":null}]}');    DrawOnMap.getData(drawingOverlay);})();