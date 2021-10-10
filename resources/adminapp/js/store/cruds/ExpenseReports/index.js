const set = key => (state, val) => {
  state[key] = val
}

function initialState() {
  return {
    data: {
      expensesSummary: {},
      incomesSummary: {},
      expensesTotal: 0,
      incomesTotal: 0,
      profit: 0
    },
    query: {}
  }
}

const route = 'expense-reports'

const getters = {
  expensesSummary: state => state.data.expensesSummary,
  incomesSummary: state => state.data.incomesSummary,
  expensesTotal: state => state.data.expensesTotal.toFixed(2),
  incomesTotal: state => state.data.incomesTotal.toFixed(2),
  profit: state => state.data.profit.toFixed(2)
}

const actions = {
  fetchIndexData({ commit, state }) {
    axios
      .get(route, { params: state.query.period })
      .then(response => {
        commit('setData', response.data.data)
      })
      .catch(error => {
        message = error.response.data.message || error.message
        // TODO error handling
      })
  },
  resetState({ commit }) {
    commit('resetState')
  },
  setQuery({ commit }, value) {
    commit('setQuery', _.cloneDeep(value))
  }
}

const mutations = {
  setData: set('data'),
  setQuery: set('query'),
  resetState(state) {
    Object.assign(state, initialState())
  }
}

export default {
  namespaced: true,
  state: initialState,
  getters,
  actions,
  mutations
}
