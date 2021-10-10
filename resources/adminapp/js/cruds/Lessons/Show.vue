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
              <strong>{{ $t('cruds.lesson.title_singular') }}</strong>
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
                          {{ $t('cruds.lesson.fields.id') }}
                        </td>
                        <td>
                          {{ entry.id }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.course') }}
                        </td>
                        <td>
                          <datatable-single :row="entry" field="course.title">
                          </datatable-single>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.title') }}
                        </td>
                        <td>
                          {{ entry.title }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.thumbnail') }}
                        </td>
                        <td>
                          <datatable-pictures :row="entry" :field="'thumbnail'">
                          </datatable-pictures>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.short_text') }}
                        </td>
                        <td>
                          {{ entry.short_text }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.long_text') }}
                        </td>
                        <td>
                          {{ entry.long_text }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.video') }}
                        </td>
                        <td>
                          <datatable-attachments :row="entry" :field="'video'">
                          </datatable-attachments>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.position') }}
                        </td>
                        <td>
                          {{ entry.position }}
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.is_published') }}
                        </td>
                        <td>
                          <datatable-checkbox :value="entry.is_published">
                          </datatable-checkbox>
                        </td>
                      </tr>
                      <tr>
                        <td class="text-primary">
                          {{ $t('cruds.lesson.fields.is_free') }}
                        </td>
                        <td>
                          <datatable-checkbox :value="entry.is_free">
                          </datatable-checkbox>
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
import DatatableAttachments from '@components/Datatables/DatatableAttachments'
import DatatableCheckbox from '@components/Datatables/DatatableCheckbox'

export default {
  components: {
    DatatableSingle,
    DatatablePictures,
    DatatableAttachments,
    DatatableCheckbox
  },
  data() {
    return {}
  },
  beforeDestroy() {
    this.resetState()
  },
  computed: {
    ...mapGetters('LessonsSingle', ['entry'])
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
    ...mapActions('LessonsSingle', ['fetchShowData', 'resetState'])
  }
}
</script>
