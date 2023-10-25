<template>
  <!-- sidebar -->
  <b-navbar class="sidebar" toggleable="lg">
    <!-- logo -->
    <b-navbar-brand class="logo">
      <nuxt-link :to="localePath('/stores')">
        <img src="~/assets/logo.jpg" v-if="this.$i18n.locale == 'en'" />
        <img src="~/assets/logo.jpg" v-else />
      </nuxt-link>
    </b-navbar-brand>

    <b-navbar-toggle target="nav-collapse" @click="toggleNav">
      <i class="fas fa-bars"></i>
    </b-navbar-toggle>

    <!-- Routes -->
    <b-collapse id="nav-collapse" is-nav>
      <div class="accordion" role="tablist">
        <b-card no-body v-show="storePermissions.includes('statistics.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="localePath('stores')" exact>
                {{ $t("admin.home") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('statistics.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="localePath('stores-store-data')" exact>
                {{ $t("admin.store") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('request_offer_quantity.index')"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.req_offer variant="default">
              <span>
                {{ $t("admin.request_offer_quantities") }}
                <svg class="icon_arrow">
                  <use
                    xlink:href="~/static/svg/sprite.svg#arrow_right_db"
                  ></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="req_offer" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link
                :to="localePath('stores-request-offer-quantity')"
                exact
              >
                <span>{{ $t("admin.new_request_offer_quantities") }}</span>
              </nuxt-link>
              <nuxt-link
                :to="
                  localeLocation({
                    name: 'stores-request-offer-quantity-replies-accepted',
                  })
                "
                exact
              >
                <span>{{
                  $t("admin.reply_request_offer_quantities_accepted")
                }}</span>
              </nuxt-link>
              <nuxt-link
                :to="
                  localeLocation({
                    name: 'stores-request-offer-quantity-replies-rejected',
                  })
                "
                exact
              >
                <span>{{
                  $t("admin.reply_request_offer_quantities_rejected")
                }}</span>
              </nuxt-link>
              <nuxt-link
                :to="
                  localeLocation({
                    name: 'stores-request-offer-quantity-replies-pending',
                  })
                "
                exact
              >
                <span>{{
                  $t("admin.reply_request_offer_quantities_sending")
                }}</span>
              </nuxt-link>
              <nuxt-link
                :to="
                  localeLocation({
                    name: 'stores-request-offer-quantity-replies-delivered',
                  })
                "
                exact
              >
                <span>{{
                  $t("admin.reply_request_offer_quantities_finished")
                }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('admins.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-admins')"
                v-show="storePermissions.includes('admins.index')"
              >
                {{ $t("admin.admins") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('roles.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-roles')"
                v-show="storePermissions.includes('roles.index')"
              >
                {{ $t("admin.roles") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('roles.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-warranties')"
                v-show="storePermissions.includes('warranties.index')"
              >
                {{ $t("admin.warranties") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->
        <!-- <b-card no-body v-show="storePermissions.includes('contact_us.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                v-show="storePermissions.includes('contact_us.index')"
                :to="localePath(`/stores/contact`)"
              >
                {{ $t("admin.contact") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card> -->

        <b-card no-body v-show="storePermissions.includes('warranties.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-warranties')"
                v-show="storePermissions.includes('warranties.index')"
              >
                {{ $t("admin.warranties") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('orders.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-product-orders`)"
                v-show="storePermissions.includes('orders.index')"
              >
                {{ $t("admin.product_orders") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('promo_codes.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/promo-codes`)"
                v-show="storePermissions.includes('promo_codes.index')"
              >
                {{ $t("admin.promoCodes") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('offers.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/offers`)"
                v-show="storePermissions.includes('offers.index')"
              >
                {{ $t("admin.offers") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('packages.subscribe')"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/packages`)"
              >
                {{ $t("admin.packages") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="storePermissions.includes('products.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-products`)"
                v-show="storePermissions.includes('products.index')"
              >
                {{ $t("admin.products") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>

        <b-card no-body v-show="storePermissions.includes('categories.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-products-categories`)"
                v-show="storePermissions.includes('categories.index')"
              >
                {{ $t("admin.categories") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>

        <b-card
          no-body
          v-show="storePermissions.includes('financial_dues.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/financial-dues`)"
                v-show="storePermissions.includes('financial_dues.index')"
              >
                {{ $t("admin.financial_dues_store_online") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card
          no-body
          v-show="storePermissions.includes('financial_dues.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/financial-dues-application`)"
                v-show="storePermissions.includes('financial_dues.index')"
              >
                {{ $t("admin.financial_dues_store_cash") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <!-- <b-card no-body>
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-notifications`)"
              >
                {{ $t("admin.notifications") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card> -->
        <!-- end:: item -->
      </div>
      <!-- end:: accordion -->
    </b-collapse>

    <div class="clone_wrapper">
      <div class="backdrop" @click="toggleNav"></div>
      <div class="accordion" role="tablist">
        <b-card
          no-body
          v-show="storePermissions.includes('statistics.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="localePath('stores')" exact>
                {{ $t("admin.home") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('statistics.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="localePath('stores-store-data')" exact>
                {{ $t("admin.store") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('request_offer_quantity.index')"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.req_offer variant="default">
              <span>
                {{ $t("admin.request_offer_quantities") }}
                <svg class="icon_arrow">
                  <use
                    xlink:href="~/static/svg/sprite.svg#arrow_right_db"
                  ></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="req_offer" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link
                  :to="localePath('stores-request-offer-quantity')"
                  exact
                >
                  <span>{{ $t("admin.new_request_offer_quantities") }}</span>
                </nuxt-link>
                <nuxt-link
                  :to="
                    localeLocation({
                      name: 'stores-request-offer-quantity-replies-accepted',
                    })
                  "
                  exact
                >
                  <span>{{
                    $t("admin.reply_request_offer_quantities_accepted")
                  }}</span>
                </nuxt-link>
                <nuxt-link
                  :to="
                    localeLocation({
                      name: 'stores-request-offer-quantity-replies-rejected',
                    })
                  "
                  exact
                >
                  <span>{{
                    $t("admin.reply_request_offer_quantities_rejected")
                  }}</span>
                </nuxt-link>
                <nuxt-link
                  :to="
                    localeLocation({
                      name: 'stores-request-offer-quantity-replies-pending',
                    })
                  "
                  exact
                >
                  <span>{{
                    $t("admin.reply_request_offer_quantities_sending")
                  }}</span>
                </nuxt-link>
                <nuxt-link
                  :to="
                    localeLocation({
                      name: 'stores-request-offer-quantity-replies-delivered',
                    })
                  "
                  exact
                >
                  <span>{{
                    $t("admin.reply_request_offer_quantities_finished")
                  }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('admins.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-admins')"
                v-show="storePermissions.includes('admins.index')"
              >
                {{ $t("admin.admins") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('roles.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-roles')"
                v-show="storePermissions.includes('roles.index')"
              >
                {{ $t("admin.roles") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('roles.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-warranties')"
                v-show="storePermissions.includes('warranties.index')"
              >
                {{ $t("admin.warranties") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('contact_us.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                v-show="storePermissions.includes('contact_us.index')"
                :to="localePath(`/stores/contact`)"
              >
                {{ $t("admin.contact") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>

        <b-card
          no-body
          v-show="storePermissions.includes('warranties.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                :to="localePath('stores-warranties')"
                v-show="storePermissions.includes('warranties.index')"
              >
                {{ $t("admin.warranties") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('orders.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-product-orders`)"
                v-show="storePermissions.includes('orders.index')"
              >
                {{ $t("admin.product_orders") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('promo_codes.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/promo-codes`)"
                v-show="storePermissions.includes('promo_codes.index')"
              >
                {{ $t("admin.promoCodes") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('offers.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/offers`)"
                v-show="storePermissions.includes('offers.index')"
              >
                {{ $t("admin.offers") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('packages.subscribe')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/packages`)"
              >
                {{ $t("admin.packages") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card
          no-body
          v-show="storePermissions.includes('products.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`stores-products`)"
                v-show="storePermissions.includes('products.index')"
              >
                {{ $t("admin.products") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>

        <b-card
          no-body
          v-show="storePermissions.includes('categories.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/products-categories`)"
                v-show="storePermissions.includes('categories.index')"
              >
                {{ $t("admin.categories") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card
          no-body
          v-show="storePermissions.includes('financial_dues.index')"
          @click="toggleNav"
        >
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link
                class="table_icon"
                :to="localePath(`/stores/financial-dues-application`)"
                v-show="storePermissions.includes('financial_dues.index')"
              >
                {{ $t("admin.financial_dues_store_cash") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->
      </div>
      <!-- end:: accordion -->
    </div>
  </b-navbar>
</template>

<script>
import { mapState } from "vuex";

export default {
  data() {
    return {
      routeName: this.$route.name, // dashboard-locations-states___en
      storePermissions: this.$cookies.get("storePermissions") || [],
    };
  },
  computed: {
    ...mapState({
      currentLocale: (state) => state.localStorage.currentLocale,
    }),
  },
  methods: {
    toggleNav() {
      document.querySelector(".clone_wrapper").classList.toggle("active");
    },
  },
};
</script>

<style>
.sidebar .dropdown button {
  background: transparent;
  border: 0;
  color: var(--color);
  border-radius: 0;
}
.sidebar .dropdown button:focus {
  outline: 0;
  box-shadow: none;
}
.dropdown-menu {
  width: 100%;
  position: relative;
  border-radius: 0;
}
</style>
<style scoped lang="scss">
/* update */
.sidebar {
  position: relative;
  min-width: 17%;
  background-color: #fff;
  flex-direction: column;
  padding: 0;
  @media (max-width: 991px) {
    flex-direction: row;
    height: 75px;
    background-color: #fff;
  }
}
.main-list {
  width: 100%;
}
.sidebar .main-list li a {
  padding-left: 10px !important;
}
.navbar-brand {
  margin-right: 0;
}
.navbar-expand-lg .navbar-collapse {
  flex-direction: column;
  width: 100%;
  max-height: calc(100% - 100px);
  overflow-y: auto;
}
.navbar-toggler {
  color: #fff;
  border: 1px solid #fff;
}
.dropdown {
  width: 100%;
}

.dropdown span {
  color: #525961;
}
@media (max-width: 600px) {
  .sidebar {
    position: absolute;
    min-width: 100%;
    z-index: 9;
    background-color: transparent;
  }
  .sidebar .main-list {
    background: #525961;
    padding-top: 10px !important;
  }
}
@media (min-width: 600px) and (max-width: 992px) {
  .sidebar {
    position: absolute;
    min-width: 60%;
    z-index: 9;
    background-color: transparent;
  }
  .sidebar .main-list {
    background: #525961;
    padding-top: 10px !important;
  }
}
.sidebar .logo {
  // padding: 0.7em 0;
  padding: 0;
  background-color: #fff;
  width: 100%;
  text-align: center;
  max-height: 130px;
}
.logout_list {
  padding-top: 1rem;
  cursor: pointer;
}

.sidebar .main-list li a {
  padding: 0.5em 1em 0.5em 0;
  font-size: 16px;
  display: block;
  color: var(--color);
  text-decoration: none;
}

.sidebar .main-list li a i {
  font-size: 20px;
  display: inline-block;
}

.sidebar .main-list li a span {
  display: inline-block;
  margin-right: 10px;
}
.sidebar .main-list li a span.statistics {
  background-color: #381058;
  color: #fff;
  padding: 5px 10px;
  border-radius: 10px;
}
/* Active Link */
.nuxt-link-active {
  color: #000 !important;
  font-weight: 600 !important;
  background-color: #eee;
}
.nuxt-link-active .statistics {
  color: #000 !important;
  background-color: #fff !important;
}

/* Media */
@media (max-width: 991px) {
  .sidebar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    overflow: hidden;
    border-bottom: 1px solid #eee;
    padding-block: 0 !important;
    padding-inline: 15px;
  }
  .sidebar .logo {
    width: 120px;
    height: 75px;
  }
  .sidebar .logo img {
    width: 100% !important;
    margin: 0 auto;
    height: 100%;
  }
}
@media (max-width: 1200px) {
  .logout_list span {
    display: none;
  }
  .sidebar .main-list li a {
    text-align: center;
    padding-right: 0;
  }

  .sidebar .main-list li a i,
  .logout_list i {
    font-size: 25px;
    display: inline-block;
  }
}
</style>

<style scoped lang="scss">
.clone_wrapper {
  display: none;
}
div[dir="rtl"] .clone_wrapper {
  left: unset;
  right: -50%;
  &.active {
    right: 0;
  }
}
@media (max-width: 991px) {
  .sidebar {
    top: 0;
    left: 0;
    width: 100%;
    padding: 12px 12px;
    .navbar-toggler {
      border-color: #000;
      color: #000;
      margin-block: 0;
    }
  }
  #nav-collapse {
    display: none !important;
  }
  .clone_wrapper {
    position: fixed;
    top: 0;
    left: -50%;
    width: 50%;
    height: 100%;
    background-color: #fff;
    display: block;
    z-index: 1001;
    transition: all 0.2s;
    .backdrop {
      content: "";
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.65);
      opacity: 0;
      visibility: hidden;
      transition: all 0.2s;
    }
    &.active {
      left: 0;
    }
    &.active .backdrop {
      opacity: 1;
      visibility: visible;
    }
    .accordion {
      background-color: #fff;
      height: 100%;
      overflow-y: auto;
      z-index: 1001;
    }
  }
}
@media (max-width: 550px) {
  .clone_wrapper {
    left: -80%;
    width: 80%;
  }
  div[dir="rtl"] .clone_wrapper {
    left: unset;
    right: -80%;
  }
}
.accordion {
  width: 100%;
  padding: 10px 8px;
  background-color: #fff;
  position: relative;
  z-index: 999;
  .card {
    padding: 0;
    margin: 0;
    margin-bottom: 5px;
    border: none;
    .card-header {
      background-color: transparent;
      padding: 0;
      border-radius: 10px;
      overflow: hidden;
      border-bottom: none;
      .btn-default {
        padding: 0;
        border: none;
        outline: none;
        box-shadow: none;
        text-align: unset;
        transition: all 0.2s;
        text-transform: capitalize;
        &:hover {
          a,
          span {
            color: #084077;
          }
        }
        &.not-collapsed {
          .icon_arrow {
            transform: rotate(-270deg);
          }
        }
        a,
        span {
          display: block;
          width: 100%;
          text-decoration: none;
          padding: 10px 10px 10px 25px;
          display: flex;
          justify-content: space-between;
          align-items: center;
          color: #000;
          .icon_arrow {
            width: 15px;
            height: 15px;
            stroke: #6e6b7b;
            fill: transparent;
            transition: all 0.2s;
          }
        }
      }
    }
    .card-body {
      padding: 0px 12px 12px 25px;
      a {
        display: block;
        color: #000;
        text-decoration: none;
        padding: 8px 18px;
        font-size: 16px;
        transition: all 0.2s;
        position: relative;
        background-color: transparent !important;
        &:hover {
          color: #084077;
        }
        &::before {
          content: "";
          position: absolute;
          top: 50%;
          left: 0;
          width: 10px;
          height: 10px;
          border-radius: 100%;
          border: 1px solid #feb322;
          background-color: transparent;
          transform: translateY(-50%);
        }
      }
    }
  }
}
.page[dir="rtl"] {
  .icon_arrow {
    transform: rotate(-180deg);
  }
  .accordion {
    .card-header .btn-default {
      a,
      span {
        padding: 10px 25px 10px 10px;
      }
    }
    .card-body {
      padding: 0px 25px 12px 12px;
    }
  }
  .card-body {
    a {
      &::before {
        content: "";
        right: 0;
        left: unset;
      }
    }
  }
}
.sidebar {
  .logo {
    a {
      background-color: transparent;
    }
  }
}

@media (max-width: 1600px) {
  .sidebar {
    min-width: 20%;
  }
}
</style>
