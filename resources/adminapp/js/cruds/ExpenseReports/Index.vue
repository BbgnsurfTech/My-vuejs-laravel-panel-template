<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">assignment</i>
            </div>
            <h4 class="card-title">
              {{ $t('cruds.expenseReport.reports.incomeReport') }}
            </h4>
          </div>
          <div class="card-body">
            <div class="row pt-3">
              <!-- Year -->
              <div class="col-md-2">
                <div class="form-group bmd-form-group has-items">
                  <label class="bmd-label-floating">
                    {{ $t('global.year') }}
                  </label>
                  <v-select
                    v-model="query.period.year"
                    :options="years"
                    :clearable="false"
                  />
                </div>
              </div>

              <!-- Month -->
              <div class="col-md-3">
                <div class="form-group bmd-form-group has-items">
                  <label class="bmd-label-floating">
                    {{ $t('global.month') }}
                  </label>
                  <v-select
                    v-model="query.period.month"
                    :options="months"
                    :clearable="false"
                    :reduce="entry => entry.value"
                  />
                </div>
              </div>
            </div>
          </div>
          <div class="card-body">
            <div class="row">
              <!-- General -->
              <div class="col-md-4">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <th>
                        {{ $t('cruds.expenseReport.reports.income') }}
                      </th>
                      <td class="text-right">{{ incomesTotal }}</td>
                    </tr>
                    <tr>
                      <th>
                        {{ $t('cruds.expenseReport.reports.expense') }}
                      </th>
                      <td class="text-right">{{ expensesTotal }}</td>
                    </tr>
                    <tr>
                      <th>
                        {{ $t('cruds.expenseReport.reports.profit') }}
                      </th>
                      <td class="text-right">{{ profit }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Income by category -->
              <div class="col-md-4">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <th>
                        {{ $t('cruds.expenseReport.reports.incomeByCategory') }}
                      </th>
                      <td class="text-right">
                        <strong>{{ incomesTotal }}</strong>
                      </td>
                    </tr>
                    <tr v-for="entry in incomesSummary" :key="entry.name">
                      <th>
                        {{ entry.name }}
                      </th>
                      <td class="text-right">{{ entry.amount.toFixed(2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>

              <!-- Expenses by category -->
              <div class="col-md-4">
                <table class="table table-striped table-bordered table-hover">
                  <tbody>
                    <tr>
                      <th>
                        {{
                          $t('cruds.expenseReport.reports.expenseByCategory')
                        }}
                      </th>
                      <td class="text-right">
                        <strong>{{ expensesTotal }}</strong>
                      </td>
                    </tr>
                    <tr v-for="entry in incomesSummary" :key="entry.name">
                      <th>{{ entry.name }}</th>
                      <td class="text-right">{{ entry.amount.toFixed(2) }}</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'

export default {
  data() {
    return {
      query: {
        period: {
          year: null,
          month: null
        }
      }
    }
  },
  created() {
    this.query.period = {
      year: moment().year(),
      month: moment().month() + 1
    }
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    query: {
      handler(query) {
        this.setQuery(query)
        this.fetchIndexData()
      },
      deep: true
    }
  },
  computed: {
    ...mapGetters('ExpenseReports', [
      'expensesSummary',
      'incomesSummary',
      'expensesTotal',
      'incomesTotal',
      'profit'
    ]),
    years: function () {
      return _.range(moment().year(), 1900)
    },
    months: function () {
      return moment.months().map((item, index) => {
        return {
          value: index + 1,
          label: item
        }
      })
    }
  },
  methods: {
    ...mapActions('ExpenseReports', [
      'fetchIndexData',
      'resetState',
      'setQuery'
    ])
  }
}
</script>
