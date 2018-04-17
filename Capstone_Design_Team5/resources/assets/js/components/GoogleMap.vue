<template>
  <div>
    <gmap-map
            :center="center"
            :zoom="16"
            style="width:100%;  height: 400px;"
    >
      <gmap-marker
              :key="index"
              v-for="(m, index) in markers"
              :position="m.position"
              :icon="m.icon"
              :label="m.infoText"
              @click="getRestaurant(m.restaurantId)"
      ></gmap-marker>
    </gmap-map>
  </div>
</template>

<script>
    export default {
        name: "GoogleMap",
        props: ['testCenter'],
        data() {
            return {
                // default to Montreal to keep it simple
                // change this to whatever makes sense
                center: this.testCenter,
                markers: [{
                    position: {lat: 33.5905447, lng: 130.3965094},
                    icon: "/images/restaurant.png",
                    restaurantId: "1"
                }, {
                    position: {lat: 33.5865284, lng: 130.3965383},
                    icon: "/images/restaurant.png",
                    restaurantId: "2"
                }, {
                    position: {lat: 33.5884537, lng: 130.4014961},
                    icon: "/images/restaurant.png",
                    restaurantId: "3"
                }, {
                    position: {lat: 33.5905139, lng: 130.4021478},
                    icon: "/images/restaurant.png",
                    restaurantId: "4"
                }, {
                    position: {lat: 33.5898338, lng: 130.4003132},
                    icon: "/images/restaurant.png",
                    restaurantId: "5"
                }, {
                    position: {lat: 33.589412, lng: 130.401871},
                    icon: "/images/restaurant.png",
                    restaurantId: "6"
                }],

                places: [],
                currentPlace: null
            };
        },

        mounted() {
            this.geolocate();
        },

        methods: {
            // receives a place object via the autocomplete component
            setPlace(place) {
                this.currentPlace = place;
            },
            addMarker() {
                if (this.currentPlace) {
                    const marker = {
                        lat: this.currentPlace.geometry.location.lat(),
                        lng: this.currentPlace.geometry.location.lng()
                    };
                    this.markers.push({ position: marker });
                    this.places.push(this.currentPlace);
                    this.center = marker;
                    this.currentPlace = null;
                }
            },
            geolocate: function() {
                navigator.geolocation.getCurrentPosition(position => {
                    this.center = {
                        lat: position.coords.latitude,
                        lng: position.coords.longitude
                    };
                });
            },
            getRestaurant: function(restaurantId) {
                alert(restaurantId + "번 가게 띄어봐라~");
            }
        }
    };
</script>