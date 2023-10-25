export const state = () => ({
  countries: [],
  states: [],
  cities: [],
});

export const mutations = {
  SET_COUNTRIES(state, payload) {
    state.countries = payload;
  },
  SET_STATES(state, payload) {
    state.states = payload;
  },
  SET_CITIES(state, payload) {
    state.cities = payload;
  },
};

export const getters = {
  get_countries(state) {
    let list = [];
    const original_array = state.countries;
    original_array.forEach((elem) => {
      list.push({
        name        : elem.name,
        value       : elem.id,
        country_code: elem.phone_code,
      });
    });
    return list;
  },
  get_states(state) {
    let list = [];
    const original_array = state.states;
    original_array.forEach((elem) => {
      list.push({
        name: elem.name,
        value: elem.id,
      });
    });
    return list;
  },
  get_cities(state) {
    let list = [];
    const original_array = state.cities;
    original_array.forEach((elem) => {
      list.push({
        name : elem.name,
        value: elem.id,
        lat  : elem.latitude,
        lng  : elem.longitude,
      });
    });
    return list;
  },
};
