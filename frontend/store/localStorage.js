export const state = () => ({
  currentLocale: "en",
  mokayiefyToken: null,
  mokayiefyPermissions: "[]",
  mokayiefyData: null,
  companyToken: null,
  companyPermissions: "[]",
  companyData: null,
  companyChat: null,
  hasChat: null,
  centerToken: null,
  centerPermissions: "[]",
  centerData: null,
  role: null,
  forgetMail: null,
  adminFirebaseToken: null,
  companyFirebaseToken: null,
});

export const getters = {
  currentLocale(state) {
    return state.currentLocale;
  },
  companyChat(state) {
    return state.companyChat;
  },
  hasChat(state) {
    return state.hasChat;
  },
  mokayiefyToken(state) {
    return state.mokayiefyToken;
  },
  mokayiefyPermissions(state) {
    return state.mokayiefyPermissions;
  },
  mokayiefyData(state) {
    return state.mokayiefyData;
  },
  companyToken(state) {
    return state.companyToken;
  },
  companyPermissions(state) {
    return state.companyPermissions;
  },
  companyData(state) {
    return state.companyData;
  },
  centerToken(state) {
    return state.centerToken;
  },
  centerPermissions(state) {
    return state.centerPermissions;
  },
  centerData(state) {
    return state.centerData;
  },
  role(state) {
    return state.role;
  },
  forgetMail(state) {
    return state.forgetMail;
  },
  companyFirebaseToken(state) {
    return state.companyFirebaseToken;
  },
  adminFirebaseToken(state) {
    return state.adminFirebaseToken;
  },
};

export const mutations = {
  SET_CURRENT_LOCALE(state, payload) {
    state.currentLocale = payload;
  },
  SET_MOKAYIEFY_TOKEN(state, payload) {
    state.mokayiefyToken = payload;
  },
  SET_MOKAYIEFY_PERMISSIONS(state, payload) {
    state.mokayiefyPermissions = payload;
  },
  SET_MOKAYIEFY_DATA(state, payload) {
    state.mokayiefyData = payload;
  },
  SET_COMPANY_TOKEN(state, payload) {
    state.companyToken = payload;
  },
  SET_HAS_CHAT(state, payload) {
    state.hasChat = payload;
  },
  SET_COMPANY_PERMISSIONS(state, payload) {
    state.companyPermissions = payload;
  },
  SET_COMPANY_DATA(state, payload) {
    state.companyData = payload;
  },
  SET_COMPANY_CHAT(state, payload) {
    state.companyChat = payload;
  },

  SET_CENTER_TOKEN(state, payload) {
    state.centerToken = payload;
  },
  SET_CENTER_PERMISSIONS(state, payload) {
    state.centerPermissions = payload;
  },
  SET_CENTER_DATA(state, payload) {
    state.centerData = payload;
  },
  SET_ROLE(state, payload) {
    state.role = payload;
  },
  SET_FORGET_MAIL(state, payload) {
    state.forgetMail = payload;
  },
  SET_COMPANY_FIREBASE_TOKEN(state, payload) {
    state.companyFirebaseToken = payload;
  },
  SET_ADMIN_FIREBASE_TOKEN(state, payload) {
    state.adminFirebaseToken = payload;
  },
  RESET_MOKAYIEFY(st) {
    // acquire initial state
    // https://github.com/vuejs/vuex/issues/1118
    // const states = state();

    const states = (({
      mokayiefyToken,
      mokayiefyPermissions,
      mokayiefyData,
      adminFirebaseToken,
      companyChat,
      hasChat,
    }) => ({
      mokayiefyToken,
      mokayiefyPermissions,
      mokayiefyData,
      adminFirebaseToken,
      companyChat,
      hasChat,
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key];
    });
    this.$cookies.remove("mokayiefyToken");
    this.$cookies.remove("permissions");
    // this.$cookies.remove('role')
  },
  RESET_COMPANY(st) {
    const states = (({
      companyToken,
      companyPermissions,
      companyData,
      companyFirebaseToken,
      companyChat,
      hasChat,
    }) => ({
      companyToken,
      companyPermissions,
      companyData,
      companyFirebaseToken,
      companyChat,
      hasChat,
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key];
    });
    this.$cookies.remove("companyToken");
    this.$cookies.remove("companyPermissions");
    // this.$cookies.remove('role')
  },
  RESET_CENTER(st) {
    const states = (({ centerToken, centerPermissions, centerData }) => ({
      centerToken,
      centerPermissions,
      centerData,
    }))(state());

    Object.keys(states).forEach((key) => {
      st[key] = states[key];
    });
    this.$cookies.remove("centerToken");
    this.$cookies.remove("centerPermissions");
    // this.$cookies.remove('role')
  },
};
