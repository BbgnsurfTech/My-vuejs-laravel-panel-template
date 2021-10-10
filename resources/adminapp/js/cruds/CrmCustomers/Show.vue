<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary card-header-icon">
            <div class="card-icon">
              <i class="material-icons">remove_red_eye</i>
            </div>
            <h4 class="card-title">
              {{ $t('global.view') }}
              <strong>{{ $t('cruds.crmCustomer.title_singular') }}</strong>
            </h4>
          </div>
          <div class="card-body">
            <back-button></back-button>
          </div>
          <div class="card-body">
            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <div class="table">
                    <tbody>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.id') }}
                        </td>
                        <td>
                          {{ entry.id }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.first_name') }}
                        </td>
                        <td>
                          {{ entry.first_name }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.last_name') }}
                        </td>
                        <td>
                          {{ entry.last_name }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.status') }}
                        </td>
                        <td>
                          <datatable-single :row="entry" field="status.name">
                          </datatable-single>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.email') }}
                        </td>
                        <td>
                          {{ entry.email }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.phone') }}
                        </td>
                        <td>
                          {{ entry.phone }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.address') }}
                        </td>
                        <td>
                          {{ entry.address }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.skype') }}
                        </td>
                        <td>
                          {{ entry.skype }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.website') }}
                        </td>
                        <td>
                          {{ entry.website }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.crmCustomer.fields.description') }}
                        </td>
                        <td>
                          {{ entry.description }}
                        </td>
                      </tr>
                    </tbody>
                  </div>
                </div>
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
import DatatableSingle from '@components/Datatables/DatatableSingle'

export default {
  components: {
    DatatableSingle
  },
  data() {
    return {}
  },
  beforeDestroy() {
    this.resetState()
  },
  computed: {
    ...mapGetters('CrmCustomersSingle', ['entry'])
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchShowData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('CrmCustomersSingle', ['fetchShowData', 'resetState'])
  }
}
</script>
