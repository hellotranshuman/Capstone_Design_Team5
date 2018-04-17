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
        data() {
            return {
                // default to Montreal to keep it simple
                // change this to whatever makes sense
                center: { lat: 33.5862667, lng: 130.4022408 },
                markers: [{
                    position: {lat: 33.5862667, lng: 130.4022408},
                    icon: "/images/restaurant.png",
                    infoText: "나는 가게요",
                    restaurantId: "1"
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