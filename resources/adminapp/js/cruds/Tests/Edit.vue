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
                <strong>{{ $t('cruds.test.title_singular') }}</strong>
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
                      'has-items': entry.course_id !== null,
                      'is-focused': activeField == 'course'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.test.fields.course')
                    }}</label>
                    <v-select
                      name="course"
                      label="title"
                      :key="'course-field'"
                      :value="entry.course_id"
                      :options="lists.course"
                      :reduce="entry => entry.id"
                      @input="updateCourse"
                      @search.focus="focusField('course')"
                      @search.blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.lesson_id !== null,
                      'is-focused': activeField == 'lesson'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.test.fields.lesson')
                    }}</label>
                    <v-select
                      name="lesson"
                      label="title"
                      :key="'lesson-field'"
                      :value="entry.lesson_id"
                      :options="lists.lesson"
                      :reduce="entry => entry.id"
                      @input="updateLesson"
                      @search.focus="focusField('lesson')"
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
                    <label class="bmd-label-floating">{{
                      $t('cruds.test.fields.title')
                    }}</label>
                    <input
                      class="form-control"
                      type="text"
                      :value="entry.title"
                      @input="updateTitle"
                      @focus="focusField('title')"
                      @blur="clearFocus"
                    />
                  </div>
                  <div
                    class="form-group bmd-form-group"
                    :class="{
                      'has-items': entry.description,
                      'is-focused': activeField == 'description'
                    }"
                  >
                    <label class="bmd-label-floating">{{
                      $t('cruds.test.fields.description')
                    }}</label>
                    <textarea
                      class="form-control"
                      rows="5"
                      :value="entry.description"
                      @input="updateDescription"
                      @focus="focusField('description')"
                      @blur="clearFocus"
                    ></textarea>
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
                      >{{ $t('cruds.test.fields.is_published') }}</label
                    >
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

export default {
  data() {
    return {
      status: '',
      activeField: ''
    }
  },
  computed: {
    ...mapGetters('TestsSingle', ['entry', 'loading', 'lists'])
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
    ...mapActions('TestsSingle', [
      'fetchEditData',
      'updateData',
      'resetState',
      'setCourse',
      'setLesson',
      'setTitle',
      'setDescription',
      'setIsPublished'
    ]),
    updateCourse(value) {
      this.setCourse(value)
    },
    updateLesson(value) {
      this.setLesson(value)
    },
    updateTitle(e) {
      this.setTitle(e.target.value)
    },
    updateDescription(e) {
      this.setDescription(e.target.value)
    },
    updateIsPublished(e) {
      this.setIsPublished(e.target.checked)
    },
    submitForm() {
      this.updateData()
        .then(() => {
          this.$router.push({ name: 'tests.index' })
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
