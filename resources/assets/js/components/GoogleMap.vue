<template>
  <div>
    <gmap-map
            id='g-map'
            :center=currentCenter
            :zoom="18"
            style="width:100%;  height: 300px;"
    >
      <gmap-marker
              :key="index"
              v-for="(m, index) in markers"
              :position="m.position"
              :icon="m.icon"
              :label="m.infoText"
              @click="getRestaurantDialog(m.restaurantId, m.restaurantName)"
      ></gmap-marker>
    </gmap-map>
    <v-dialog v-model="restaurantInfo" width="500">
      <v-card>
        <v-card-title class="headline">{{restaurantTitle}}</v-card-title>
        <v-card-actions>
          <v-flex>
            <v-card-media id="modalImg" :src="restaurantImg" height="200px"></v-card-media>
            <v-card-actions>
              <v-btn flat color="orange" :to="toInfo" style="width: 33%">Info</v-btn>
              <v-btn flat color="orange" :to="toMenu" style="width: 33%">Menu</v-btn>
              <v-btn flat color="orange" :to="toReview" style="width: 33%">Review</v-btn>
            </v-card-actions>
          </v-flex>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
    import axios  from 'axios';
    export default {
        name: "GoogleMap",
        props: ['currentCenter'],
        data() {
            return {
                restaurantInfo: false,
                restaurantTitle: "test",
                restaurantImg: "",
                toInfo: "",
                toMenu: "",
                toReview: "",
                // default to Montreal to keep it simple
                // change this to whatever makes sense
                markers: [],

                places: [],
                currentPlace: null,
            };
        },

        mounted: function() {
            this.geolocate();

            var tp = "";
            var temp = [
                {
                    'position': {lat: 35.8962134, lng: 128.6197624},
                    'icon': "/images/restaurant.png",
                    'restaurantId': 1,
                    'restaurantName' : '식당이름1'
                },
                {
                    'position': {lat: 35.8964134, lng: 128.6192624},
                    'icon': "/images/restaurant.png",
                    'restaurantId': 2,
                    'restaurantName' : '식당이름2'
                },
                {
                    'position': {lat: 35.8968134, lng: 128.6198624},
                    'icon': "/images/restaurant.png",
                    'restaurantId': 3,
                    'restaurantName' : '식당이름3'
                },
            ]
            while(tp = temp.pop()) {
                this.markers.push(tp);
            }
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

            searchAddress(searchAddressInput) {
                if (searchAddressInput) {
                    const marker = {
                        lat: searchAddressInput.geometry.location.lat(),
                        lng: searchAddressInput.geometry.location.lng()
                    };
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

            getRestaurantDialog(getId, getName) {
                this.restaurantTitle = getName;
                this.restaurantInfo = true;
                this.restaurantImg = "/images/" + getId + "/" + getId + "_titleImg.jpg"
                this.toInfo = "/restaurant/" + getId + "/info";
                this.toMenu = "/restaurant/" + getId + "/menu";
                this.toReview = "/restaurant/"+ getId +"/review";
            }
        }
    };
</script>