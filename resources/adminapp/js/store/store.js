import Vue from 'vue'
import Vuex from 'vuex'

import Alert from './modules/alert'
import I18NStore from './modules/i18n'

import PermissionsIndex from './cruds/Permissions'
import PermissionsSingle from './cruds/Permissions/single'
import RolesIndex from './cruds/Roles'
import RolesSingle from './cruds/Roles/single'
import UsersIndex from './cruds/Users'
import UsersSingle from './cruds/Users/single'
import ProductCategoriesIndex from './cruds/ProductCategories'
import ProductCategoriesSingle from './cruds/ProductCategories/single'
import ProductTagsIndex from './cruds/ProductTags'
import ProductTagsSingle from './cruds/ProductTags/single'
import ProductsIndex from './cruds/Products'
import ProductsSingle from './cruds/Products/single'
import CrmStatusesIndex from './cruds/CrmStatuses'
import CrmStatusesSingle from './cruds/CrmStatuses/single'
import CrmCustomersIndex from './cruds/CrmCustomers'
import CrmCustomersSingle from './cruds/CrmCustomers/single'
import CrmNotesIndex from './cruds/CrmNotes'
import CrmNotesSingle from './cruds/CrmNotes/single'
import CrmDocumentsIndex from './cruds/CrmDocuments'
import CrmDocumentsSingle from './cruds/CrmDocuments/single'
import ContentCategoriesIndex from './cruds/ContentCategories'
import ContentCategoriesSingle from './cruds/ContentCategories/single'
import ContentTagsIndex from './cruds/ContentTags'
import ContentTagsSingle from './cruds/ContentTags/single'
import ContentPagesIndex from './cruds/ContentPages'
import ContentPagesSingle from './cruds/ContentPages/single'
import ContactCompaniesIndex from './cruds/ContactCompanies'
import ContactCompaniesSingle from './cruds/ContactCompanies/single'
import ContactContactsIndex from './cruds/ContactContacts'
import ContactContactsSingle from './cruds/ContactContacts/single'
import FaqCategoriesIndex from './cruds/FaqCategories'
import FaqCategoriesSingle from './cruds/FaqCategories/single'
import FaqQuestionsIndex from './cruds/FaqQuestions'
import FaqQuestionsSingle from './cruds/FaqQuestions/single'
import CoursesIndex from './cruds/Courses'
import CoursesSingle from './cruds/Courses/single'
import LessonsIndex from './cruds/Lessons'
import LessonsSingle from './cruds/Lessons/single'
import TestsIndex from './cruds/Tests'
import TestsSingle from './cruds/Tests/single'
import QuestionsIndex from './cruds/Questions'
import QuestionsSingle from './cruds/Questions/single'
import QuestionOptionsIndex from './cruds/QuestionOptions'
import QuestionOptionsSingle from './cruds/QuestionOptions/single'
import TestResultsIndex from './cruds/TestResults'
import TestResultsSingle from './cruds/TestResults/single'
import TestAnswersIndex from './cruds/TestAnswers'
import TestAnswersSingle from './cruds/TestAnswers/single'
import ExpenseCategoriesIndex from './cruds/ExpenseCategories'
import ExpenseCategoriesSingle from './cruds/ExpenseCategories/single'
import IncomeCategoriesIndex from './cruds/IncomeCategories'
import IncomeCategoriesSingle from './cruds/IncomeCategories/single'
import ExpensesIndex from './cruds/Expenses'
import ExpensesSingle from './cruds/Expenses/single'
import IncomesIndex from './cruds/Incomes'
import IncomesSingle from './cruds/Incomes/single'
import ExpenseReports from './cruds/ExpenseReports'

Vue.use(Vuex)

const debug = process.env.NODE_ENV !== 'production'

export default new Vuex.Store({
  modules: {
    Alert,
    I18NStore,
    PermissionsIndex,
    PermissionsSingle,
    RolesIndex,
    RolesSingle,
    UsersIndex,
    UsersSingle,
    ProductCategoriesIndex,
    ProductCategoriesSingle,
    ProductTagsIndex,
    ProductTagsSingle,
    ProductsIndex,
    ProductsSingle,
    CrmStatusesIndex,
    CrmStatusesSingle,
    CrmCustomersIndex,
    CrmCustomersSingle,
    CrmNotesIndex,
    CrmNotesSingle,
    CrmDocumentsIndex,
    CrmDocumentsSingle,
    ContentCategoriesIndex,
    ContentCategoriesSingle,
    ContentTagsIndex,
    ContentTagsSingle,
    ContentPagesIndex,
    ContentPagesSingle,
    ContactCompaniesIndex,
    ContactCompaniesSingle,
    ContactContactsIndex,
    ContactContactsSingle,
    FaqCategoriesIndex,
    FaqCategoriesSingle,
    FaqQuestionsIndex,
    FaqQuestionsSingle,
    CoursesIndex,
    CoursesSingle,
    LessonsIndex,
    LessonsSingle,
    TestsIndex,
    TestsSingle,
    QuestionsIndex,
    QuestionsSingle,
    QuestionOptionsIndex,
    QuestionOptionsSingle,
    TestResultsIndex,
    TestResultsSingle,
    TestAnswersIndex,
    TestAnswersSingle,
    ExpenseCategoriesIndex,
    ExpenseCategoriesSingle,
    IncomeCategoriesIndex,
    IncomeCategoriesSingle,
    ExpensesIndex,
    ExpensesSingle,
    IncomesIndex,
    IncomesSingle,
    ExpenseReports
  },
  strict: debug
})
