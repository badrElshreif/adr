<template>
  <!-- sidebar -->
  <b-navbar class="sidebar" toggleable="lg">
    <!-- logo -->
    <b-navbar-brand class="logo">
      <nuxt-link :to="{
                  path: localePath(`dashboard`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }">
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
        <b-card no-body>
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="{
                  path: localePath(`dashboard`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" exact>
                {{ $t("admin.home") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('countries.index') ||
            permissions.includes('states.index') ||
            permissions.includes('cities.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.locations_perm variant="default">
              <span>
                {{ $t("admin.locations") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="locations_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link :to="{
                  path: localePath(`dashboard-locations-countries`),
                  query:this.$route.query,
                }" v-show="permissions.includes('countries.index')">
                <span>{{ $t("admin.countries") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-locations-states`),
                  query:this.$route.query,
                }" v-show="permissions.includes('states.index')">
                <span>{{ $t("admin.states") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-locations-cities`),
                  query:this.$route.query,
                }" v-show="permissions.includes('cities.index')">
                <span>{{ $t("admin.cities") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('admins.index') ||
            permissions.includes('roles.index') ||
            permissions.includes('users.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.users_perm variant="default">
              <span>
                {{ $t("admin.users_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="users_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link :to="{
                  path: localePath(`dashboard-admins`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('admins.index')">
                <span>{{ $t("admin.admins") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-roles`),
                  query:this.$route.query,
                }" v-show="permissions.includes('roles.index')">
                <span>{{ $t("admin.roles") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-users`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('users.index')">
                <span>{{ $t("admin.users") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('settings.index') ||
            permissions.includes('brands.index') ||
            permissions.includes('warranties.index') ||
            permissions.includes('service_types.index') ||
            permissions.includes('currency.index') ||
            permissions.includes('bank_accounts.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.settings_perm variant="default">
              <span>
                {{ $t("admin.settings") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="settings_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-settings`),
                  query:this.$route.query,
                }" v-show="permissions.includes('settings.index')">
                <span>{{ $t("admin.general_settings") }}</span>
              </nuxt-link>
              <!-- <nuxt-link :to="{
                  path: localePath(`dashboard-payment-methods`),
                  query:this.$route.query,
                }" class="table_icon" v-show="permissions.includes('settings.index')">
                <span>{{ $t("admin.payment_methods") }}</span>
              </nuxt-link> -->
              <nuxt-link :to="{
                  path: localePath(`dashboard-brands`),
                  query:this.$route.query,
                }" v-show="permissions.includes('brands.index')">
                <span>{{ $t("admin.brands") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-currency`),
                  query:this.$route.query,
                }" v-show="permissions.includes('currency.index')">
                <span>{{ $t("admin.currency") }}</span>
              </nuxt-link>
              <nuxt-link :to="{
                  path: localePath(`dashboard-bank-accounts`),
                  query:this.$route.query,
                }" v-show="permissions.includes('bank_accounts.index')">
                <span>{{ $t("admin.bank_accounts") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->
        <b-card no-body v-show="
            permissions.includes('pages.index') ||
            permissions.includes('settings.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.content_perm variant="default">
              <span>
                {{ $t("admin.content_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="content_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-content`),
                  query:this.$route.query,
                }" v-show="permissions.includes('pages.index')">
                {{ $t("admin.static_pages") }}
              </nuxt-link>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-home-content`),
                  query:this.$route.query,
                }" v-show="permissions.includes('settings.index')">
                {{ $t("admin.home_content") }}
              </nuxt-link>
              <!-- <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-home-slider`),
                  query:this.$route.query,
                }" v-show="permissions.includes('settings.index')">
                {{ $t("admin.slider_content") }}
              </nuxt-link> -->
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body>
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link :to="localePath(`/dashboard/rooms`)" exact>
                {{ $t("admin.focus_rooms") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>

        <b-card no-body v-show="
            permissions.includes('products.index') ||
            permissions.includes('properties.index') ||
            permissions.includes('services.index') ||
            permissions.includes('comments.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.products_perm variant="default">
              <span>
                {{ $t("admin.products") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="products_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-additional-fields`),
                  query:this.$route.query,
                }" v-show="permissions.includes('properties.index')">
                <span>{{ $t("admin.properties") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-products`),
                  query:this.$route.query,
                }" v-show="permissions.includes('products.index')">
                <span>{{ $t("admin.products") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('stores.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.stores_perm variant="default">
              <span>
                {{ $t("admin.stores") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="stores_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-current-stores`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('stores.index')">
                <span>{{ $t("admin.current_stores") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="localePath(`dashboard-stores-requests`)"
                v-show="permissions.includes('stores.index')">
                <span>{{ $t("admin.stores_join_requests") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('deliveries.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.deliveries_perm variant="default">
              <span>
                {{ $t("admin.deliveries") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="deliveries_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-current-deliveries`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }">
                <span>{{ $t("admin.current_deliveries") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-deliveries-requests`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }">
                <span>{{ $t("admin.join_req_deliveries") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-current-deliveries-delete`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }">
                <span>{{ $t("admin.join_req_deliveries_delete") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-ratings`),
                  query:this.$route.query,
                  }" v-show="permissions.includes('comments.index')">
                <span>{{ $t("admin.deliveries_ratings") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('national_zones.index') ||
            permissions.includes('zones.index') ||
            permissions.includes('shippings-categories.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.pricing_perm variant="default">
              <span>
                {{ $t("admin.pricing") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="pricing_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="localePath('dashboard-pricing-zones')"
                v-show="permissions.includes('zones.index')">
                <span>{{ $t("admin.zones") }}</span>
              </nuxt-link>
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/shippings-categories`)"
                v-show="permissions.includes('shippings-categories.index')">
                {{ $t("admin.shippings_categories") }}
              </nuxt-link>
              <nuxt-link class="table_icon" :to="localePath('dashboard-pricing-national-zones')"
                v-show="permissions.includes('national_zones.index')">
                <span>{{ $t("admin.national_zones") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('orders.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.order_m_perm variant="default">
              <span>
                {{ $t("admin.orders_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-product-orders`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('orders.index')">
                <span>{{ $t("admin.stores_orders") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-products-outer-orders`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('orders.index')">
                <span>{{ $t("admin.products_outer_orders") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-product-scheduled-orders`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('scheduled_orders.index')">
                <span>{{ $t("admin.scheduled_orders") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-shippings-orders`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('shippings_orders.index')">
                <span>{{ $t("admin.shippings_orders") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel"
            v-show="permissions.includes('map.index')">
            <b-card-body>
              <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-map`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('map.index')">
                <span>{{ $t("admin.map") }}</span>
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->
        <b-card no-body v-show="
            permissions.includes('payments.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.payments_perm variant="default">
              <span>
                {{ $t("admin.payments") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="payments_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-payments-stores`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.payments_to_store") }}</span>
                </nuxt-link>
                <nuxt-link class="table_icon" :to="localePath(`dashboard-payments-deliveries`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.payments_to_delivery") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="
            permissions.includes('financial_dues.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.delivery_payments_perm variant="default">
              <span>
                {{ $t("admin.financial_dues") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="delivery_payments_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-financial-dues-application`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.financial_dues_cash") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="permissions.includes('files.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/backgrounds`)"
                v-show="permissions.includes('files.index')">
                {{ $t("admin.backgrounds") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card no-body v-show="permissions.includes('files.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/sounds`)"
                v-show="permissions.includes('files.index')">
                {{ $t("admin.sounds") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card no-body v-show="permissions.includes('packages.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/packages`)"
                v-show="permissions.includes('packages.index')">
                {{ $t("admin.companies_packages") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card no-body v-show="permissions.includes('packages.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/focus-packages`)"
                v-show="permissions.includes('packages.index')">
                {{ $t("admin.focus_packages") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card no-body v-show="permissions.includes('users.transactions')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/delivery-transfer`)"
                v-show="permissions.includes('users.transactions')">
                {{ $t("admin.delivery_transfer") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <b-card no-body v-show="permissions.includes('users.transactions')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/user-transfer`)"
                v-show="permissions.includes('users.transactions')">
                {{ $t("admin.user_transfer") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('ads.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/slides`)"
                v-show="permissions.includes('ads.index')">
                {{ $t("admin.ads") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('banners.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/banner`)"
                v-show="permissions.includes('banners.index')">
                {{ $t("admin.banners") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('offers.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/offers`)"
                v-show="permissions.includes('offers.index')">
                {{ $t("admin.offers") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('notifications.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.notify_perm variant="default">
              <span>
                {{ $t("admin.notifications") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="notify_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="{
                    path: localePath(`dashboard-notification`),
                    query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                  }" v-show="permissions.includes('notifications.index')">
                  <span>{{ $t("admin.sent_notifications") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`/dashboard/notification/recieved`)"
                  v-show="permissions.includes('notifications.index')">
                  <span>{{ $t("admin.recieved_notifications") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('contact_us.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/contact`)"
                v-show="permissions.includes('contact_us.index')">
                {{ $t("admin.contact") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('promo_codes.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/promo-codes`)"
                v-show="permissions.includes('promo_codes.index')">
                {{ $t("admin.promoCodes") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->
      </div>
      <!-- end:: accordion -->
    </b-collapse>

    <div class="clone_wrapper">
      <div class="backdrop" @click="toggleNav"></div>
      <div class="accordion" role="tablist">
        <b-card no-body>
          <b-card-header header-tag="header" role="tab" @click="toggleNav">
            <b-button block variant="default">
              <nuxt-link :to="{
                  path: localePath(`dashboard`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" exact>
                {{ $t("admin.home") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('countries.index') ||
            permissions.includes('states.index') ||
            permissions.includes('cities.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.locations_perm variant="default">
              <span>
                {{ $t("admin.locations") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="locations_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-locations-countries')"
                  v-show="permissions.includes('countries.index')">
                  <span>{{ $t("admin.countries") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-locations-states')" v-show="permissions.includes('states.index')">
                  <span>{{ $t("admin.states") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-locations-cities')" v-show="permissions.includes('cities.index')">
                  <span>{{ $t("admin.cities") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('admins.index') ||
            permissions.includes('roles.index') ||
            permissions.includes('users.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.users_perm variant="default">
              <span>
                {{ $t("admin.users_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="users_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link :to="{
                  path: localePath(`dashboard-admins`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('admins.index')">
                  <span>{{ $t("admin.admins") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-roles')" v-show="permissions.includes('roles.index')">
                  <span>{{ $t("admin.roles") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="{
                  path: localePath(`dashboard-users`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('users.index')">
                  <span>{{ $t("admin.users") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('settings.index') ||
            permissions.includes('brands.index') ||
            permissions.includes('warranties.index') ||
            permissions.includes('service_types.index') ||
            permissions.includes('currency.index') ||
            permissions.includes('bank_accounts.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.settings_perm variant="default">
              <span>
                {{ $t("admin.settings") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="settings_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-settings`)"
                  v-show="permissions.includes('settings.index')">
                  <span>{{ $t("admin.general_settings") }}</span>
                </nuxt-link>
              </div>
              <!-- <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-payment-methods`)"
                  v-show="permissions.includes('settings.index')">
                  <span>{{ $t("admin.payment_methods") }}</span>
                </nuxt-link>
              </div> -->
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-brands')" v-show="permissions.includes('brands.index')">
                  <span>{{ $t("admin.brands") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-currency')" v-show="permissions.includes('currency.index')">
                  <span>{{ $t("admin.currency") }}</span>
                </nuxt-link>
              </div>
              <div @click="toggleNav">
                <nuxt-link :to="localePath('dashboard-bank-accounts')"
                  v-show="permissions.includes('bank_accounts.index')">
                  <span>{{ $t("admin.bank_accounts") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->
        <b-card no-body v-show="
            permissions.includes('pages.index') ||
            permissions.includes('faqs.index') ||
            permissions.includes('settings.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.content_perm variant="default">
              <span>
                {{ $t("admin.content_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="content_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/content`)"
                v-show="permissions.includes('pages.index')">
                {{ $t("admin.static_pages") }}
              </nuxt-link>
              <nuxt-link class="table_icon"  :to="localePath('dashboard-faqs')"
              v-show="permissions.includes('faqs.index')">
              <span>{{ $t("admin.faqs") }}</span>
            </nuxt-link>
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/home-content`)"
                v-show="permissions.includes('settings.index')">
                {{ $t("admin.home_content") }}
              </nuxt-link>
              <!-- <nuxt-link class="table_icon" :to="localePath(`/dashboard/slider-content`)"
                v-show="permissions.includes('settings.index')">
                {{ $t("admin.slider_content") }}
              </nuxt-link> -->
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="
            permissions.includes('rooms.index')          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.categories_perm variant="default">
              <span>
                {{ $t("admin.categories") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="rooms_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/rooms`)"
                v-show="permissions.includes('rooms.index')">
                {{ $t("admin.focus_rooms") }}
              </nuxt-link>
            </b-card-body>
          </b-collapse>
        </b-card>

        <!--<b-card-->
        <!--no-body-->
        <!--v-show="permissions.includes('pages.index')"-->
        <!--@click="toggleNav"-->
        <!--&gt;-->
        <!--<b-card-header header-tag="header" role="tab">-->
        <!--<b-button block variant="default">-->
        <!--<nuxt-link-->
        <!--class="table_icon"-->
        <!--:to="localePath(`/dashboard/content`)"-->
        <!--v-show="permissions.includes('pages.index')"-->
        <!--&gt;-->
        <!--{{ $t("admin.static_pages") }}-->
        <!--</nuxt-link>-->
        <!--</b-button>-->
        <!--</b-card-header>-->
        <!--</b-card>-->
        <!-- end:: item -->

        <b-card no-body v-show="
            permissions.includes('products.index') ||
            permissions.includes('properties.index') ||
            permissions.includes('services.index') ||
            permissions.includes('comments.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.products_perm variant="default">
              <span>
                {{ $t("admin.products") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="products_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-additional-fields`),
                  query:this.$route.query,
                  }" v-show="permissions.includes('properties.index')">
                  <span>{{ $t("admin.properties") }}</span>
                </nuxt-link>
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-products`),
                  query:this.$route.query,
                  }" v-show="permissions.includes('products.index')">
                  <span>{{ $t("admin.products") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('stores.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.stores_perm variant="default">
              <span>
                {{ $t("admin.stores") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="stores_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-current-stores`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('stores.index')">
                  <span>{{ $t("admin.current_stores") }}</span>
                </nuxt-link>
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-stores-requests`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('stores.index')">
                  <span>{{ $t("admin.stores_join_requests") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('orders.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.order_m_perm variant="default">
              <span>
                {{ $t("admin.orders_management") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="order_m_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-product-orders`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('orders.index')">
                  <span>{{ $t("admin.product_orders") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="
            permissions.includes('payments.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.payments_perm variant="default">
              <span>
                {{ $t("admin.payments") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="payments_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-payments-stores`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.payments_to_store") }}</span>
                </nuxt-link>
                <nuxt-link class="table_icon" :to="localePath(`dashboard-paymen`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.payments_to_delivery") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="
            permissions.includes('financial_dues.index')
          ">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.delivery_payments_perm variant="default">
              <span>
                {{ $t("admin.financial_dues") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="delivery_payments_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`dashboard-financial-dues-application`)"
                  v-show="permissions.includes('payments.index')">
                  <span>{{ $t("admin.financial_dues_cash") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <b-card no-body v-show="permissions.includes('packages.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/packages`)"
                v-show="permissions.includes('packages.index')">
                {{ $t("admin.companies_packages") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('ads.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/slides`)"
                v-show="permissions.includes('ads.index')">
                {{ $t("admin.ads") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('banners.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/banner`)"
                v-show="permissions.includes('banners.index')">
                {{ $t("admin.banners") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('offers.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/offers`)"
                v-show="permissions.includes('offers.index')">
                {{ $t("admin.offers") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('notifications.index')">
          <b-card-header header-tag="header" role="tab">
            <b-button block v-b-toggle.notify_perm variant="default">
              <span>
                {{ $t("admin.notifications") }}
                <svg class="icon_arrow">
                  <use xlink:href="~/static/svg/sprite.svg#arrow_right_db"></use>
                </svg>
              </span>
            </b-button>
          </b-card-header>
          <b-collapse id="notify_perm" accordion="my-accordion" role="tabpanel">
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="{
                  path: localePath(`dashboard-notifications`),
                  query: { country_id: this.$route.query.country_id, state_id: this.$route.query.state_id, city_id: this.$route.query.city_id },
                 }" v-show="permissions.includes('notifications.index')">
                  <span>{{ $t("admin.sent_notifications") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
            <b-card-body>
              <div @click="toggleNav">
                <nuxt-link class="table_icon" :to="localePath(`/dashboard/notification/recieved`)"
                  v-show="permissions.includes('notifications.index')">
                  <span>{{ $t("admin.recieved_notifications") }}</span>
                </nuxt-link>
              </div>
            </b-card-body>
          </b-collapse>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('contact_us.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/contact`)"
                v-show="permissions.includes('contact_us.index')">
                {{ $t("admin.contact") }}
              </nuxt-link>
            </b-button>
          </b-card-header>
        </b-card>
        <!-- end:: item -->

        <b-card no-body v-show="permissions.includes('promo_codes.index')" @click="toggleNav">
          <b-card-header header-tag="header" role="tab">
            <b-button block variant="default">
              <nuxt-link class="table_icon" :to="localePath(`/dashboard/promo-codes`)"
                v-show="permissions.includes('promo_codes.index')">
                {{ $t("admin.promoCodes") }}
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
  import {
    mapState
  } from "vuex";

  export default {
    data() {
      return {
        routeName: this.$route.name, // dashboard-locations-states___en
        permissions: this.$cookies.get("permissions") || [],
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

  // @media (max-width: 1600px) {
  //   .sidebar {
  //     min-width: 25%;
  //   }
  // }

</style>
