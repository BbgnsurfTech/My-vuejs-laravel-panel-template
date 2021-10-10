function initialState() {
  return {
    entry: {
      id: null,
      course_id: null,
      title: '',
      thumbnail: [],
      short_text: '',
      long_text: '',
      video: [],
      position: '',
      is_published: false,
      is_free: false,
      created_at: '',
      updated_at: '',
      deleted_at: ''
    },
    lists: {
      course: []
    },
    loading: false
  }
}

const route = 'lessons'

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
  setCourse({ commit }, value) {
    commit('setCourse', value)
  },
  setTitle({ commit }, value) {
    commit('setTitle', value)
  },
  insertThumbnailFile({ commit }, file) {
    commit('insertThumbnailFile', file)
  },
  removeThumbnailFile({ commit }, file) {
    commit('removeThumbnailFile', file)
  },
  setShortText({ commit }, value) {
    commit('setShortText', value)
  },
  setLongText({ commit }, value) {
    commit('setLongText', value)
  },
  insertVideoFile({ commit }, file) {
    commit('insertVideoFile', file)
  },
  removeVideoFile({ commit }, file) {
    commit('removeVideoFile', file)
  },
  setPosition({ commit }, value) {
    commit('setPosition', value)
  },
  setIsPublished({ commit }, value) {
    commit('setIsPublished', value)
  },
  setIsFree({ commit }, value) {
    commit('setIsFree', value)
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
  setCourse(state, value) {
    state.entry.course_id = value
  },
  setTitle(state, value) {
    state.entry.title = value
  },
  insertThumbnailFile(state, file) {
    state.entry.thumbnail.push(file)
  },
  removeThumbnailFile(state, file) {
    state.entry.thumbnail = state.entry.thumbnail.filter(item => {
      return item.id !== file.id
    })
  },
  setShortText(state, value) {
    state.entry.short_text = value
  },
  setLongText(state, value) {
    state.entry.long_text = value
  },
  insertVideoFile(state, file) {
    state.entry.video.push(file)
  },
  removeVideoFile(state, file) {
    state.entry.video = state.entry.video.filter(item => {
      return item.id !== file.id
    })
  },
  setPosition(state, value) {
    state.entry.position = value
  },
  setIsPublished(state, value) {
    state.entry.is_published = value
  },
  setIsFree(state, value) {
    state.entry.is_free = value
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
