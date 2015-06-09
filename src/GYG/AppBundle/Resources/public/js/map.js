var DrawOnMap = {    imageRootFolder: '',    drawingOptions: {        polygon: 'Polygon',        lineString: 'LineString',        point: 'Point',        multiPoint: 'MultiPoint',        multiLineString: 'MultiLineString',        multiPolygon: 'MultiPolygon'    },    //Initialize the map api and create a map on the front    initialize: function (startOption, map) {        var drawingOverlay;        this.imageRootFolder = startOption.imageRootFolder ? startOption.imageRootFolder : '';        map = new ol.Map({            target: 'map',            layers: [                new ol.layer.Tile({                    source: new ol.source.MapQuest({layer: 'osm'})                })            ],            view: new ol.View({                center: [startOption.initLat, startOption.initLong],                zoom: startOption.initZoom            })        });        this.positionFeature = new ol.Feature({            content: 'Vous êtes ici'        });        this.positionFeature.setStyle(new ol.style.Style({            image: new ol.style.Icon({                src: '../img/location.png',                scale: 0.5,                opacity: 0.7,                anchor: [0.5, 1]            })        }));        drawingOverlay = this._initializeDrawingLayer(map);        if(startOption.editable) {            this._addModifyInteraction(map, drawingOverlay);            this._addDrawingInteraction(startOption.drawType, startOption.singleDrawMode, map, drawingOverlay);        } else {            this._addPopupInteraction(map, drawingOverlay);        }        return drawingOverlay;    },    //Initialize the layer where the features (points) are placed    _initializeDrawingLayer: function(map) {        drawingOverlay = new ol.FeatureOverlay({            style: new ol.style.Style({                fill: new ol.style.Fill({                    color: 'rgba(100, 100, 100, 0.2)'                }),                stroke: new ol.style.Stroke({                    color: '#FF3A28',                    width: 3                }),                image: new ol.style.Circle({                    radius: 10,                    fill: new ol.style.Fill({                        color: '#FF3A28'                    }),                    stroke: new ol.style.Stroke({                        color: '#ffffff',                        width: 3                    })                })            })        })        drawingOverlay.setMap(map);        return drawingOverlay;    },    //Initialize the modify interaction to move an already placed point    _addModifyInteraction: function(map, drawingOverlay) {        var modify = new ol.interaction.Modify({            features: drawingOverlay.getFeatures(),            deleteCondition: function(event) {                return ol.events.condition.shiftKeyOnly(event) && ol.events.condition.singleClick(event);            }        });        map.addInteraction(modify);    },    //Initialize the drawing interaction    _addDrawingInteraction: function(typeOfDrawing, singleFeatureMode, map, drawingOverlay) {        var draw = new ol.interaction.Draw({            features: drawingOverlay.getFeatures(),            type: typeOfDrawing,            condition: function(event) {                if(singleFeatureMode) {                    return drawingOverlay.getFeatures().getLength() < 1;                }                return true;            },            freehandCondition: function(event) {                return false;            }        });        map.addInteraction(draw);    },    setData: function(drawingOverlay, data, typeOfFeature) {        var interactions;        var features;        var modify;        var map = drawingOverlay.getMap();        interactions = map.getInteractions().getArray();        interactions.forEach(function(item, index, array){           if(item instanceof ol.interaction.Modify) {               modify = item;               map.removeInteraction(item);           }        });        features = (new ol.format.GeoJSON()).readFeatures(data.geoJson);        features.forEach(function(item, index, array) {            switch(typeOfFeature) {                case 'pointapport':                    this._setStyleForPoint(item, data, typeOfFeature);                    break;                case 'trajet':                    this._setStyleForTrajet(item, data);                    break;                case 'dechetsoin':                    this._setStyleForPoint(item, data, typeOfFeature);                    break;                case 'textile':                    this._setStyleForPoint(item, data, typeOfFeature);                    break;                case 'dechetterie':                    this._setStyleForPoint(item, data, typeOfFeature);                    break;            }            drawingOverlay.addFeature(item);        }, this);        if(modify) {            modify.features = drawingOverlay.getFeatures();            map.addInteraction(modify);        }    },    getData: function(drawingOverlay) {        var res ;        var features;        features = drawingOverlay.getFeatures().getArray();        if(features.length > 0)            res = (new ol.format.GeoJSON()).writeFeatures(features);        return res;    },    geolocation: function(drawingOverlay) {        var geolocation = new ol.Geolocation({            projection: drawingOverlay.getMap().getView().getProjection()        });        geolocation.setTracking(true);        geolocation.on('change:position', function() {            var coordinates = geolocation.getPosition();            drawingOverlay.getMap().getView().setCenter(coordinates);            this.positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);            if(drawingOverlay.getFeatures().getArray().indexOf(this.positionFeature) == -1)                drawingOverlay.addFeature(this.positionFeature);        }, this);    },    _addPopupInteraction: function(map, layer) {        var element = document.getElementById('popup');        map.on('click', function(evt) {            var feature = map.forEachFeatureAtPixel(evt.pixel, function(feature, layer) {                return feature;            });            if(feature) {                $('#modal-information').html(feature.get('content'));                $(element).modal('show');            }        });    },    _setStyleForTrajet: function(feature, data) {        var couleur = '#' + data.couleur;         feature.setStyle(new ol.style.Style({            stroke: new ol.style.Stroke({                color: couleur,                width: 3            })        }));    },    _setStyleForPoint: function(feature, data, typeOfFeature) {        var iconToUse;        switch(typeOfFeature) {            case 'pointapport':                iconToUse = this._getIconForPointApport(data);                break;            case 'dechetterie':                iconToUse = '../img/dechetterie.png';                break            case 'dechetsoin':                iconToUse = '../img/sante.png';                break            case 'textile':                iconToUse = '../img/textile.png';                break        }        feature.setStyle(new ol.style.Style({            image: new ol.style.Icon({                src: iconToUse,                scale: 0.5,                opacity: 1,                anchor: [0.5, 1]            })        }));    },    _getIconForPointApport: function(data) {        var currentDechet = [];        var bitmask = '000';        bitmask = bitmask.split('');        data.dechets.forEach(function(dechet, indexDechet, arrayDechets) {            currentDechet.push(dechet.type);        })        if(data.type === 'aerien') {            if(currentDechet.indexOf('verre') !== -1) bitmask[0] = 1;            if(currentDechet.indexOf('metallique') !== -1 || currentDechet.indexOf('plastique') != -1) bitmask[2] = 1;            if(currentDechet.indexOf('papier-carton') !== -1) bitmask[1] = 1;            bitmask = bitmask.join('');            switch(bitmask) {                case '001': return this.imageRootFolder + 'pointAerien-jaune.png';                case '010': return this.imageRootFolder + 'pointAerien-bleu.png';                case '011': return this.imageRootFolder + 'pointAerien-jaune-bleu.png';                case '100': return this.imageRootFolder + 'pointAerien-vert.png';                case '101': return this.imageRootFolder + 'pointAerien-jaune-vert.png';                case '110': return this.imageRootFolder + 'pointAerien-vert-bleu.png';                case '111': return this.imageRootFolder + 'pointAerien-jaune-vert-bleu.png';            }        } else {            if(currentDechet.indexOf('verre') !== -1) bitmask[1] = 1;            if(currentDechet.indexOf('papier-carton') !== -1 || currentDechet.indexOf('metallique') !== -1 || currentDechet.indexOf('plastique') != -1) bitmask[2] = 1;            if(currentDechet.indexOf('menager') !== -1) bitmask[0] = 1;            bitmask = bitmask.join('');            switch(bitmask) {                case '001': return this.imageRootFolder + 'pointEnterre-jaune.png';                case '010': return this.imageRootFolder + 'pointEnterre-vert.png';                case '011': return this.imageRootFolder + 'pointEnterre-jaune-vert.png';                case '100': return this.imageRootFolder + 'pointEnterre-gris.png';                case '101': return this.imageRootFolder + 'pointEnterre-jaune.png';                case '110': return this.imageRootFolder + 'pointEnterre-vert-gris.png';                case '111': return this.imageRootFolder + 'pointEnterre-jaune-vert-gris.png';            }        }        return '';    },    getLocalisationFromAddress: function(drawingOverlay, address) {        $.ajax({            url: "http://maps.googleapis.com/maps/api/geocode/json?address=" + address,            context: this        }).done(function(item) {            if(item.status == 'OK') {                var coordinates = [item.results[0].geometry.location.lng, item.results[0].geometry.location.lat];                coordinates = ol.proj.transform(coordinates, 'EPSG:4326', 'EPSG:3857');                drawingOverlay.getMap().getView().setCenter(coordinates);                this.positionFeature.setGeometry(coordinates ? new ol.geom.Point(coordinates) : null);                if(drawingOverlay.getFeatures().getArray().indexOf(this.positionFeature) == -1)                    drawingOverlay.addFeature(this.positionFeature);            }        });    },    removeAllFeatures: function(drawingOverlay) {        drawingOverlay.getFeatures().clear();        drawingOverlay.addFeature(this.positionFeature);    }}