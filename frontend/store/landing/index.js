export const state = () => ({
  slider: [],
  webSettings: [],
  home_content: [],
});

export const mutations = {
  SET_SETTINGS(state, payload) {
    state.webSettings = payload;
  },
  SET_HOME_CONTENT(state, payload) {
    state.home_content = payload;
  },
  SET_SLIDER(state, payload) {
    state.slider = payload;
  },
};

export const getters = {
  get_settings(state) {
    return state.webSettings;
  },
  get_home_content(state) {
    return state.home_content;
  },
  get_slider(state) {
    return state.slider;
  },
};
