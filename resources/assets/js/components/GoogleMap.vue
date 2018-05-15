<template>
  <div>
    <gmap-map
            :center=currentCenter
            :zoom="16"
            style="width:100%;  height: 400px;"
    >
      <gmap-marker
              :key="index"
              v-for="(m, index) in markers"
              :position="m.position"
              :icon="m.icon"
              :label="m.infoText"
              @click="getFunction(m.restaurantId)"
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
                }, {
                    position: {lat: 35.8962134, lng: 128.6194624},
                    icon: "/images/restaurant.png",
                    restaurantId: "7"
                }, {
                    position: {lat: 35.8962534, lng: 128.6199624},
                    icon: "/images/restaurant.png",
                    restaurantId: "8"
                }],

                places: [],
                currentPlace: null,
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
            getRestaurant: function(restaurantId) {
                location.replace("/restaurant/" + restaurantId + "/info");
            },
            getFunction(getId) {
                switch(getId) {
                    case "1":
                        this.restaurantTitle = "Umecchaga"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/1/1_titleImg.jpg"
                        this.toInfo = "/restaurant/1/info";
                        this.toMenu = "/restaurant/1/menu";
                        this.toReview = "/restaurant/1/review";
                        break;
                    case "2":
                        this.restaurantTitle = "Jukuseihanamidoritokamameshi"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/2/2_titleImg.jpg"
                        this.toInfo = "/restaurant/2/info";
                        this.toMenu = "/restaurant/2/menu";
                        this.toReview = "/restaurant/2/review";
                        break;
                    case "3":
                        this.restaurantTitle = "Kushiagetokisetsunooryouri"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/3/3_titleImg.jpg"
                        this.toInfo = "/restaurant/3/info";
                        this.toMenu = "/restaurant/3/menu";
                        this.toReview = "/restaurant/3/review";
                        break;
                    case "4":
                        this.restaurantTitle = "Hakatanaginoki"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/4/4_titleImg.jpg"
                        this.toInfo = "/restaurant/4/info";
                        this.toMenu = "/restaurant/4/menu";
                        this.toReview = "/restaurant/4/review";
                        break;
                    case "5":
                        this.restaurantTitle = "Wafuukushiagetenzen"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/5/5_titleImg.jpg"
                        this.toInfo = "/restaurant/5/info";
                        this.toMenu = "/restaurant/5/menu";
                        this.toReview = "/restaurant/5/review";
                        break;
                    case "6":
                        this.restaurantTitle = "Kado-no-Casshiwa"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/6/6_titleImg.jpg"
                        this.toInfo = "/restaurant/6/info";
                        this.toMenu = "/restaurant/6/menu";
                        this.toReview = "/restaurant/6/review";
                        break;
                    case "7":
                        this.restaurantTitle = "영진반점"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/6/6_titleImg.jpg"
                        this.toInfo = "/restaurant/7/info";
                        this.toMenu = "/restaurant/7/menu";
                        this.toReview = "/restaurant/7/review";
                        break;
                    case "8":
                        this.restaurantTitle = "서문동까스"
                        this.restaurantInfo = true;
                        this.restaurantImg = "/images/6/6_titleImg.jpg"
                        this.toInfo = "/restaurant/8/info";
                        this.toMenu = "/restaurant/8/menu";
                        this.toReview = "/restaurant/8/review";
                        break;
                }
            }
        }
    };
</script>