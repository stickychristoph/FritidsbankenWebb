/* global
 settings, google, XMLHttpRequest */

/* eslint-disable no-new */

import mapboxgl from 'mapbox-gl';

class FindBank {
  constructor(elem) {
    console.log('FindBank');
    this.elem = elem;
    this.map = null;

    this.bankLocationsRequest = null;
    this.nearestBankRequest = null;

    this.mapMarkers = [];

    this.container = this.elem.querySelectorAll('#search-wrapper')[0];
    this.searchField = this.elem.querySelectorAll('#search-text')[0];
    this.results = this.elem.querySelectorAll('#search-result')[0];
    this.bankList = this.elem.querySelectorAll('#bank-list')[0];
    this.bankElements = this.elem.querySelectorAll('#bank-list > li');
    this.mapLegend = this.elem.querySelectorAll('#map-legend')[0];
    this.nearestBankLoader = this.elem.querySelectorAll(
      '#nearest-bank-loader'
    )[0];

    this.init();
    this.initMap();
  }

  init() {
    const scope = this;

    if (window.location.hash && window.location.hash.includes('narmast')) {
      if ('geolocation' in navigator) {
        // console.log('show LOADER');
        this.nearestBankLoader.classList.add('loading');
        const geo = navigator.geolocation;
        // console.log(geo);
        geo.getCurrentPosition(
          function (pos) {
            console.log('Get pos success', pos);
            scope.getNearestBank(pos);
          },
          //,
          function (err) {
            console.log(err);
            scope.nearestBankLoader.classList.remove('loading');
          }
        );
      }
    }

    this.bankElements.forEach((elem) => {
      const localId = parseInt(elem.getAttribute('data-id'));

      elem.addEventListener('click', (e) => {
        if (elem.classList.contains('active')) {
          elem.classList.remove('active');

          scope.mapMarkers.forEach((m) => {
            m.classList.remove('active');
          });
          return;
        }
        scope.bankElements.forEach((be) => {
          if (be.classList.contains('active')) {
            be.classList.remove('active');
          }
        });

        elem.classList.add('active');

        scope.mapMarkers.forEach(function (m) {
          if (parseInt(m.id) !== localId) {
            m.classList.remove('active');
          } else {
            m.classList.add('active');
            scope.map.flyTo({
              center: [m.dataset.lng, m.dataset.lat],
              zoom: scope.map.getZoom() < 6 ? 7 : scope.map.getZoom(),
            });
          }
        });
      });
    });

    this.searchField.addEventListener('keyup', (evt) => {
      const value = evt.target.value;

      if (value.length === 0) {
        scope.bankElements.forEach((be) => {
          if (be.classList.contains('hidden')) {
            be.classList.remove('hidden');
          }
        });
      }

      scope.bankElements.forEach((elem) => {
        if (
          elem
            .getAttribute('data-city')
            .trim()
            .toLowerCase()
            .indexOf(value.trim().toLowerCase()) === -1
        ) {
          elem.classList.add('hidden');
        } else if (elem.classList.contains('hidden')) {
          elem.classList.remove('hidden');
        }
      });

      const visibleCount = scope.elem.querySelectorAll(
        '#bank-list > li:not(.hidden)'
      ).length;

      if (visibleCount === 0) {
        scope.mapLegend.classList.add('hidden');
      } else {
        scope.mapLegend.classList.remove('hidden');
      }
    });
  }

  initMap() {
    // console.log('initMap');

    mapboxgl.accessToken =
      'pk.eyJ1IjoiZnJpdGlkc2JhbmtlbiIsImEiOiJjbHJvbHVrbHMxYTdnMm1xcmZoY29wZzhkIn0.a-r3-x6nprrRc_X324KAkw';
    this.map = new mapboxgl.Map({
      container: 'map', // container ID
      style: 'mapbox://styles/mapbox/streets-v12', // style URL
      center: [16.095896, 62.769194], // starting position [lng, lat]
      zoom: 4, // starting zoom
    });
    this.loadBankLocations(this.placeMarkers, this);
  }

  placeMarkers(data) {
    // console.log('placeMarkers', data);

    const banks = JSON.parse(data).banks;
    banks.forEach((bankData) => {
      const el = document.createElement('div');
      el.className = 'marker';
      if (bankData.isOpening) {
        el.className = 'marker opening-soon';
      } else if (bankData.hasParent) {
        el.className = 'marker has-parent';
      } else {
        el.className = 'marker';
      }

      el.style.width = '19px';
      el.style.height = '25px';
      el.style.backgroundSize = '100%';
      // set bankdata.id as id
      el.id = bankData.ID;
      el.dataset.lat = bankData.position.lat;
      el.dataset.lng = bankData.position.lng;

      const scope = this;

      el.addEventListener('click', function (evt) {
        const clickedMarker = this;
        el.classList.add('active');

        scope.mapMarkers.forEach((m) => {
          if (parseInt(m.id) !== parseInt(clickedMarker.id)) {
            m.classList.remove('active');
          }
        });

        scope.map.flyTo({
          center: [bankData.position.lng, bankData.position.lat],
          zoom: scope.map.getZoom() < 6 ? 7 : scope.map.getZoom(),
        });

        scope.setActiveItem(clickedMarker.id);
      });

      const marker = new mapboxgl.Marker(el)
        .setLngLat([bankData.position.lng, bankData.position.lat])
        .addTo(this.map);

      this.mapMarkers.push(el);
    });
  }

  loadBankLocations(callback, scope) {
    this.bankLocationsRequest = new XMLHttpRequest();

    this.bankLocationsRequest.open('POST', settings.ajaxurl, true);
    this.bankLocationsRequest.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded; charset=UTF-8'
    );

    this.bankLocationsRequest.onload = function () {
      callback.call(scope, this.response);
    };

    this.bankLocationsRequest.onerror = function () {
      // Connection error
    };
    this.bankLocationsRequest.send('action=getBankLocations');
  }

  setActiveItem(id) {
    // const scope = this;

    this.container.scrollTop = 0;

    this.bankElements.forEach((elem) => {
      if (elem.classList.contains('active')) {
        elem.classList.remove('active');
      }
    });

    this.bankElements.forEach((elem) => {
      if (parseInt(elem.getAttribute('data-id')) === parseInt(id)) {
        elem.classList.add('active');
        this.container.scrollTop = elem.offsetTop;
      }
    });
  }

  getNearestBank(position) {
    // console.log('getNearestBank');
    const scope = this;
    this.nearestBankRequest = new XMLHttpRequest();

    this.nearestBankRequest.open('POST', settings.ajaxurl, true);
    this.nearestBankRequest.setRequestHeader(
      'Content-Type',
      'application/x-www-form-urlencoded; charset=UTF-8'
    );

    this.nearestBankRequest.onload = function () {
      const data = JSON.parse(this.response);
      scope.nearestBankLoader.classList.remove('loading');

      const bankNode = scope.bankList.querySelectorAll(
        "[data-id='" + data.id + "']"
      )[0];
      bankNode.click();
      bankNode.scrollIntoView();
    };

    this.nearestBankRequest.onerror = function () {
      // Connection error
      scope.nearestBankLoader.classList.remove('loading');
    };
    this.nearestBankRequest.send(
      'action=nearestBank&lat=' +
        position.coords.latitude +
        '&lng=' +
        position.coords.longitude
    );
  }
}
export default FindBank;
