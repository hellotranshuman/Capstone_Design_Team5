<template>
  <div>
    <gmap-map
            id='g-map'
            :center=googleMapCenter
            :zoom="9"
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
        props: ['currentCenter', 'googleMapMode'],
        data() {
            return {
                googleMapCenter: this.currentCenter,
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

        created: function() {
            this.geolocate();

            if(!this.currentCenter) {
                var restaurantList = [];

                if(this.googleMapMode == 'top') {
                    restaurantList = this.$session.get('top_restaurantList');
                } else if(this.googleMapMode == 'search') {
                    for(var key in this.$session.get('searchData').shopSearchData) {
                        restaurantList.push(this.$session.get('searchData').shopSearchData[key]);
                    }
                    for(var key in this.$session.get('searchData').typeSearchData) {
                        restaurantList.push(this.$session.get('searchData').typeSearchData[key]);
                    }
                    for(var key in this.$session.get('searchData').regionSearchData) {
                        restaurantList.push(this.$session.get('searchData').regionSearchData[key]);
                    }
                    for(var key in this.$session.get('searchData').tagSearchData) {
                        restaurantList.push(this.$session.get('searchData').tagSearchData[key]);
                    }
                    console.log(restaurantList);
                }

                if(restaurantList.length == 0) {
                    this.googleMapCenter = {'lat': 35.6622958, 'lng': 138.1452445}
                    return;
                }
                var avg_lat = 0;
                var avg_lng = 0;
                var count = 0;

                for(var key in restaurantList) {
                    var temp = restaurantList[key].coordinate.replace('(', '');
                    var temp2 = temp.replace(')', '');
                    var temp3 = temp2.split(', ');
                    avg_lat += Number(temp3[0]);
                    avg_lng += Number(temp3[1]);
                    count++;

                    this.markers.push({
                        'position': {lat: Number(temp3[0]), lng: Number(temp3[1])},
                        'icon': "/images/restaurant.png",
                        'restaurantId': restaurantList[key].shop_id,
                        'restaurantName' : restaurantList[key].shop_name
                    });
                }

                this.googleMapCenter = {'lat': avg_lat / count, 'lng': avg_lng / count};
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