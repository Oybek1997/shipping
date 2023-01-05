<template>
  <v-card elevation="0">
    <v-app-bar color="#337ab7" dense app>
      <v-app-bar-nav-icon color="white" @click.stop="drawer = !drawer">
        <v-icon>mdi-menu</v-icon>
      </v-app-bar-nav-icon>

      <v-spacer></v-spacer>

      <!-- <v-menu offset-y>
        <template v-slot:activator="{ on }">
          <v-btn color="white" text v-on="on">
            <v-icon color="#white" left>mdi-flag</v-icon>
            {{ languages[$i18n.locale] }}
          </v-btn>
        </template>
        <v-list>
          <v-list-item
            v-for="(item, index) in locales"
            :key="index"
            @click="setLocale(item.value)"
          >
            <v-list-item-title>{{ item.text }}</v-list-item-title>
          </v-list-item>
        </v-list>
      </v-menu>-->
      <v-btn color="white" text @click="Logout">
        <v-icon color="white" class="ml-2">mdi-logout</v-icon>
        {{ user && user.username ? user.username : '' }}
      </v-btn>
    </v-app-bar>
    <v-navigation-drawer
      v-if="drawerShow"
      class="darken-4"
      color="#337ab7"
      :expand-on-hover="!drawer"
      dark
      permanent
      app
      id="navbar"
    >
      <v-list subheader class="pb-0">
        <v-list-item @click="staff = false" to="/" :title="$t('message.home')">
          <v-list-item-content color="#163e72">
            <v-list-item-title
              class="text-h5 text-center"
              style="color: #ffff; font-weight: 600;"
              v-text="$t('UzAuto Motors')"
            ></v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-divider></v-divider>

      <v-list dense v-for="item in MenuItems" :key="item.title" class="pb-1">
        <v-list-item v-if="item.visible" link :to="item.link">
          <v-list-item-icon class="mr-1">
            <v-icon>{{ item.icon }}</v-icon>
          </v-list-item-icon>

          <v-list-item-content class="ml-5">
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>

      <v-list dense class="dropdown">
        <v-list-group
          v-for="item in items"
          :key="item.title"
          link
          :to="item.link"
        >
          <template v-slot:activator>
            <v-icon>{{ item.icon }}</v-icon>
            <v-list-item-content class="ml-5">
              <v-list-item-title v-text="item.title"></v-list-item-title>
            </v-list-item-content>
          </template>
          <v-list-item
            v-for="subItem in item.items"
            :key="subItem.title"
            link
            :to="subItem.link"
          >
            <v-icon>{{ subItem.icon }}</v-icon>
            <v-list-item-content class="ml-2">
              <v-list-item-title v-text="subItem.title"></v-list-item-title>
            </v-list-item-content>
          </v-list-item>
        </v-list-group>
      </v-list>
    </v-navigation-drawer>

    <v-main>
      <router-view></router-view>
    </v-main>
  </v-card>
</template>
<script>
import Cookies from 'js-cookie';

export default {
  data() {
    return {
      locales: [
        { value: `uz_latin`, text: `O'zbekcha` },
        { value: `uz_cyril`, text: `Ўзбекча` },
        { value: `ru`, text: `Русский` },
        { value: `eng`, text: `English` },
      ],
      languages: {
        uz_latin: `O'zbekcha`,
        uz_cyril: `Ўзбекча`,
        ru: `Русский`,
        eng: `English`,
      },
      drawer: true,
      drawerShow: true,
      mini: true,
    };
  },
  computed: {
    user() {
      return this.$store.state.user;
    },
    MenuItems() {
      return [
        { title: this.$t('main_page'), icon: 'mdi-home-outline', link: '/' },
        // {
        //   title: this.$t('Excel'),
        //   icon: 'mdi-file-excel',
        //   link: '/excel',
        //   visible: this.roles('admin') || this.roles('supply'),
        // },

        {
          title: this.$t('Table'),
          icon: 'mdi-file-table',
          link: '/table',
          visible: false,
        },
        {
          title: this.$t('Vehicles'),
          icon: 'mdi-car',
          link: '/vehicles',
          //visible: false,
           visible: this.roles('admin')
        },
        {
          title: this.$t('Dilers'),
          icon: 'mdi-home-outline',
          link: '/dilers',
          //visible: false,
          visible: this.roles('admin')
        },
        {
          title: this.$t('Diler Wins'),
          icon: 'mdi-file-table',
          link: '/dilerwins',
          //visible: false,
          visible: this.roles('admin')
        },
        {
          title: this.$t('Dilers Statistics'),
          icon: 'mdi-calendar',
          link: '/statistics',
          //visible: false,
          visible: this.roles('admin')
        },
        {
          title: this.$t('Date Statistics'),
          icon: 'mdi-calendar',
          link: '/statisticstwo',
          //visible: false,
          visible: this.roles('admin')
        },
        {
          title: this.$t('User Statistics'),
          icon: 'mdi-calendar',
          link: '/statisticsthree',
          //visible: false,
          visible: this.roles('admin')
        },
        {
          title: this.$t('Diler Users'),
          icon: 'mdi-account',
          link: '/dilerusers',
          //visible: false,
          visible: this.roles('admin')
        },
        // {
        //   title: this.$t('Details'),
        //   icon: 'mdi-hammer-wrench',
        //   link: '/details',
        //   // visible: false,
        //   visible: this.roles('admin')
        // },
        {
          title: this.$t('user.index'),
          icon: 'mdi-account-group',
          link: '/users',
          visible: this.roles('admin'),
        },
        {
          title: this.$t('Hodimlar'),
          icon: 'mdi-account-group',
          link: '/employees',
          visible: false,
          // visible: this.roles('admin'),
        },
        {
          title: this.$t('user.logs'),
          icon: 'mdi-account-clock',
          link: '/userlogs',
          visible: false,
          // visible: this.roles('admin')
        },
      ];
    },
    items() {
      return [
        // {
        //   title: this.$t('admin_panel'),
        //   icon: 'mdi-security',
        //   active: true,
        //   // visible: (this.$store.state.user.role_id = 1),
        //   items: [
        //     // {
        //     //   title: this.$t('user.index'),
        //     //   icon: 'mdi-account-group',
        //     //   link: '/users',
        //     //   // visible: (this.$store.state.user.role_id = 1),
        //     // },
        //     // {
        //     //   title: this.$t('user.logs'),
        //     //   icon: 'mdi-account-clock',
        //     //   link: '/userlogs',
        //     // },
        //   ],
        // },
      ];
    },
  },
  methods: {
    roles(sts) {
      if (this.user && sts == this.user.role.name) {
        return true;
      } else {
        return false;
      }
    },
    setLocale: function(arg) {
      this.$i18n.locale = arg;
      this.$store.dispatch('setLocale', arg);
    },
    Logout() {
      Cookies.remove('access_token');
      Cookies.remove('user');
      this.$router.push('/login');
    },
  },
};
// console.log(this.user);
</script>

<style scoped>
.dropdown .v-list-item--active {
  color: #fff;
}

.dropdown .v-list-item__title {
  color: #fff;
}
.v-application .primary--text {
  color: rgb(157, 157, 248) !important;
}
.v-list {
  padding: 0;
}
</style>
