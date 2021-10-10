<template>
  <div class="container-fluid">
    <form @submit.prevent="submitForm">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">edit</i>
              </div>
              <h4 class="card-title">
                {{ $t('global.edit') }}
                <strong>{{ $t('cruds.course.title_singular') }}</strong>
              </h4>
            </div>
            <div class="card-body">
              <back-button></back-button>
            </div>
            <div class="card-body">
              <bootstrap-alert />
              <div class="row">
                <div class="col-md-12">
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.teacher_id !== null,
                      'is-focused': activeField == 'teacher'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.course.fields.teacher')
                    }}</label>
                    <v-select
                      name="teacher"
                      label="name"
                      :key="'teacher-field'"
                      :value="entry.teacher_id"
                      :options="lists.teacher"
                      :reduce="entry => entry.id"
                      @input="updateTeacher"
                      @search.focus="focusField('teacher')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.title,
                      'is-focused': activeField == 'title'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.course.fields.title')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.title"
                      @input="updateTitle"
                      @focus="focusField('title')"
                      @blur="clearFocus"
                      required
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.description,
                      'is-focused': activeField == 'description'
                    }"
                  >
                    <label class="bmd-label-floating required">{{
                      $t('cruds.course.fields.description')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.description"
                      @input="updateDescription"
                      @focus="focusField('description')"
                      @blur="clearFocus"
                      required
                    ></textarea>
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.price,
                      'is-focused': activeField == 'price'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.course.fields.price')
                    }}</label>
                    <input
                      class="form-control"
                      type="number"
                      step="0.01"
                      :value="entry.price"
                      @input="updatePrice"
                      @focus="focusField('price')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div class="form-group">
                    <label>{{ $t('cruds.course.fields.thumbnail') }}</label>
                    <attachment
                      :route="getRoute('courses')"
                      :collection-name="'course_thumbnail'"
                      :media="entry.thumbnail"
                      :model-id="$route.params.id"
                      :max-file-size="2"
                      :component="'pictures'"
                      :accept="'image/*'"
                      @file-uploaded="insertThumbnailFile"
                      @file-removed="removeThumbnailFile"
                    />
                  </div>
                  <div class="form-group form-check">
                    <label class="form-check-label"
                      ><input
                        class="form-check-input"
                        type="checkbox"
                        :value="entry.is_published"
                        :checked="entry.is_published"
                        @change="updateIsPublished"
                      /><span class="form-check-sign"
                        ><span class="check"></span></span
                      >{{ $t('cruds.course.fields.is_published') }}</label
                    >
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.students.length !== 0,
                      'is-focused': activeField == 'students'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.course.fields.students')
                    }}</label>
                    <v-select
                      name="students"
                      label="name"
                      :key="'students-field'"
                      :value="entry.students"
                      :options="lists.students"
                      :closeOnSelect="false"
                      multiple
                      @input="updateStudents"
                      @search.focus="focusField('students')"
                      @search.blur="clearFocus"
                    />
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              <vue-button-spinner
                class="btn-primary"
                :status="status"
                :isLoading="loading"
                :disabled="loading"
              >
                {{ $t('global.save') }}
              </vue-button-spinner>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
import Attachment from '@components/Attachments/Attachment'

export default {
  components: {
    Attachment
  },
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('CoursesSingle', ['entry', 'loading', 'lists'])
  },
  beforeDestroy() {
    this.resetState()
  },
  watch: {
    '$route.params.id': {
      immediate: true,
      handler() {
        this.resetState()
        this.fetchEditData(this.$route.params.id)
      }
    }
  },
  methods: {
    ...mapActions('CoursesSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setTeacher',
      'setTitle',
      'setDescription',
      'setPrice',
      'insertThumbnailFile',
      'removeThumbnailFile',
      'setIsPublished',
      'setStudents'
    ]),
    updateTeacher(value) {
      this.setTeacher(value)
    },
    updateTitle(e) {
      this.setTitle(e.target.value)
    },
    updateDescription(e) {
      this.setDescription(e.target.value)
    },
    updatePrice(e) {
      this.setPrice(e.target.value)
    },
    updateIsPublished(e) {
      this.setIsPublished(e.target.checked)
    },
    updateStudents(value) {
      this.setStudents(value)
    },
    getRoute(name) {
      return `${axios.defaults.baseURL}${name}/media`
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'courses.index' })
          this.$eventHub.$emit('update-success')
        })
        .catch(error => {
          this.status = 'failed'
          _.delay(() => {
            this.status = ''
          }, 3000)
        })
    },
    focusField(name) {
      this.activeField = name
    },
    clearFocus() {
      this.activeField = ''
    }
  }
}
</script>
