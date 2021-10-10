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
              <strong>{{ $t('cruds.question.title_singular') }}</strong>
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
                          {{ $t('cruds.question.fields.id') }}
                        </td>
                        <td>
                          {{ entry.id }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.question.fields.course') }}
                        </td>
                        <td>
                          <datatable-single :row="entry" field="course.title">
                          </datatable-single>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.question.fields.question_text') }}
                        </td>
                        <td>
                          {{ entry.question_text }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.question.fields.question_image') }}
                        </td>
                        <td>
                          <datatable-pictures
                            :row="entry"
                            :field="'question_image'"
                          >
                          </datatable-pictures>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.question.fields.points') }}
                        </td>
                        <td>
                          {{ entry.points }}
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
import DatatablePictures from '@components/Datatables/DatatablePictures'

export default {
  components: {
    DatatableSingle,
    DatatablePictures
  },
  data() {
    return {}
  },
  beforeDestroy() {
    this.resetState()
  },
  computed: {
    ...mapGetters('QuestionsSingle', ['entry'])
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
    ...mapActions('QuestionsSingle', ['fetchShowData', 'resetState'])
  }
}
</script>
