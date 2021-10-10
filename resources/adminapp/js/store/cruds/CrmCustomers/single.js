function initialState() {
  return {
    entry: {
      id: null,
      first_name: '',
      last_name: '',
      status_id: null,
      email: null,
      phone: '',
      address: '',
      skype: '',
      website: '',
      description: '',
      created_at: '',
      updated_at: '',
      deleted_at: ''
    },
    lists: {
      status: []
    },
    loading: false
  }
}

const route = 'crm-customers'

const getters = {
  entry: state => state.entry,
  lists: state => state.lists,
  loading: state => state.loading
}

const actions = {
  storeData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = objectToFormData(state.entry, {
        indices: true,
        booleansAsIntegers: true
      })
      axios
        .post(route, params)
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          let message = error.response.data.message || error.message
          let errors = error.response.data.errors

          dispatch(
            'Alert/setAlert',
            { message: message, errors: errors, color: 'danger' },
            { root: true }
          )

          reject(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    })
  },
  updateData({ commit, state, dispatch }) {
    commit('setLoading', true)
    dispatch('Alert/resetState', null, { root: true })

    return new Promise((resolve, reject) => {
      let params = objectToFormData(state.entry, {
        indices: true,
        booleansAsIntegers: true
      })
      params.set('_method', 'PUT')
      axios
        .post(`${route}/${state.entry.id}`, params)
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          let message = error.response.data.message || error.message
          let errors = error.response.data.errors

          dispatch(
            'Alert/setAlert',
            { message: message, errors: errors, color: 'danger' },
            { root: true }
          )

          reject(error)
        })
        .finally(() => {
          commit('setLoading', false)
        })
    })
  },
  setFirstName({ commit }, value) {
    commit('setFirstName', value)
  },
  setLastName({ commit }, value) {
    commit('setLastName', value)
  },
  setStatus({ commit }, value) {
    commit('setStatus', value)
  },
  setEmail({ commit }, value) {
    commit('setEmail', value)
  },
  setPhone({ commit }, value) {
    commit('setPhone', value)
  },
  setAddress({ commit }, value) {
    commit('setAddress', value)
  },
  setSkype({ commit }, value) {
    commit('setSkype', value)
  },
  setWebsite({ commit }, value) {
    commit('setWebsite', value)
  },
  setDescription({ commit }, value) {
    commit('setDescription', value)
  },
  setCreatedAt({ commit }, value) {
    commit('setCreatedAt', value)
  },
  setUpdatedAt({ commit }, value) {
    commit('setUpdatedAt', value)
  },
  setDeletedAt({ commit }, value) {
    commit('setDeletedAt', value)
  },
  fetchCreateData({ commit }) {
    axios.get(`${route}/create`).then(response => {
      commit('setLists', response.data.meta)
    })
  },
  fetchEditData({ commit, dispatch }, id) {
    axios.get(`${route}/${id}/edit`).then(response => {
      commit('setEntry', response.data.data)
      commit('setLists', response.data.meta)
    })
  },
  fetchShowData({ commit, dispatch }, id) {
    axios.get(`${route}/${id}`).then(response => {
      commit('setEntry', response.data.data)
    })
  },
  resetState({ commit }) {
    commit('resetState')
  }
}

const mutations = {
  setEntry(state, entry) {
    state.entry = entry
  },
  setFirstName(state, value) {
    state.entry.first_name = value
  },
  setLastName(state, value) {
    state.entry.last_name = value
  },
  setStatus(state, value) {
    state.entry.status_id = value
  },
  setEmail(state, value) {
    state.entry.email = value
  },
  setPhone(state, value) {
    state.entry.phone = value
  },
  setAddress(state, value) {
    state.entry.address = value
  },
  setSkype(state, value) {
    state.entry.skype = value
  },
  setWebsite(state, value) {
    state.entry.website = value
  },
  setDescription(state, value) {
    state.entry.description = value
  },
  setCreatedAt(state, value) {
    state.entry.created_at = value
  },
  setUpdatedAt(state, value) {
    state.entry.updated_at = value
  },
  setDeletedAt(state, value) {
    state.entry.deleted_at = value
  },
  setLists(state, lists) {
    state.lists = lists
  },
  setLoading(state, loading) {
    state.loading = loading
  },
  resetState(state) {
    state = Object.assign(state, initialState())
  }
}

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations
}
