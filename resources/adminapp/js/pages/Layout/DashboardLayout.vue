<template>
  <div class="wrapper" :class="{ 'nav-open': $sidebar.showSidebar }">
    <event-hub></event-hub>
    <side-bar :sidebarLinks="sidebarLinks">
      <mobile-menu slot="content"></mobile-menu>
    </side-bar>

    <div class="main-panel">
      <top-navbar></top-navbar>
      <div class="content">
        <dashboard-content></dashboard-content>
      </div>
    </div>
  </div>
</template>

<script>
import DashboardContent from './Content.vue'
import TopNavbar from './TopNavbar.vue'
import MobileMenu from './MobileMenu.vue'

export default {
  components: {
    DashboardContent,
    TopNavbar,
    MobileMenu
  },
  data() {
    return {
      sidebarLinks: [
        {
          title: 'global.dashboard',
          icon: 'dashboard',
          path: { name: 'dashboard' }
        },
        {
          title: 'cruds.userManagement.title',
          icon: 'person',
          path: { name: 'user_management' },
          gate: 'user_management_access',
          children: [
            {
              title: 'cruds.permission.title',
              icon: 'perm_data_setting',
              path: { name: 'permissions.index' },
              gate: 'permission_access'
            },
            {
              title: 'cruds.role.title',
              icon: 'group',
              path: { name: 'roles.index' },
              gate: 'role_access'
            },
            {
              title: 'cruds.user.title',
              icon: 'person',
              path: { name: 'users.index' },
              gate: 'user_access'
            }
          ]
        },
        {
          title: 'cruds.productManagement.title',
          icon: 'table_view',
          path: { name: 'product_management' },
          gate: 'product_management_access',
          children: [
            {
              title: 'cruds.productCategory.title',
              icon: 'table_view',
              path: { name: 'product_categories.index' },
              gate: 'product_category_access'
            },
            {
              title: 'cruds.productTag.title',
              icon: 'table_view',
              path: { name: 'product_tags.index' },
              gate: 'product_tag_access'
            },
            {
              title: 'cruds.product.title',
              icon: 'table_view',
              path: { name: 'products.index' },
              gate: 'product_access'
            }
          ]
        },
        {
          title: 'cruds.basicCRM.title',
          icon: 'table_view',
          path: { name: 'basic_c_r_m' },
          gate: 'basic_c_r_m_access',
          children: [
            {
              title: 'cruds.crmStatus.title',
              icon: 'table_view',
              path: { name: 'crm_statuses.index' },
              gate: 'crm_status_access'
            },
            {
              title: 'cruds.crmCustomer.title',
              icon: 'table_view',
              path: { name: 'crm_customers.index' },
              gate: 'crm_customer_access'
            },
            {
              title: 'cruds.crmNote.title',
              icon: 'table_view',
              path: { name: 'crm_notes.index' },
              gate: 'crm_note_access'
            },
            {
              title: 'cruds.crmDocument.title',
              icon: 'table_view',
              path: { name: 'crm_documents.index' },
              gate: 'crm_document_access'
            }
          ]
        },
        {
          title: 'cruds.contentManagement.title',
          icon: 'table_view',
          path: { name: 'content_management' },
          gate: 'content_management_access',
          children: [
            {
              title: 'cruds.contentCategory.title',
              icon: 'table_view',
              path: { name: 'content_categories.index' },
              gate: 'content_category_access'
            },
            {
              title: 'cruds.contentTag.title',
              icon: 'table_view',
              path: { name: 'content_tags.index' },
              gate: 'content_tag_access'
            },
            {
              title: 'cruds.contentPage.title',
              icon: 'table_view',
              path: { name: 'content_pages.index' },
              gate: 'content_page_access'
            }
          ]
        },
        {
          title: 'cruds.contactManagement.title',
          icon: 'import_contacts',
          path: { name: 'contact_management' },
          gate: 'contact_management_access',
          children: [
            {
              title: 'cruds.contactCompany.title',
              icon: 'fas fa-building',
              path: { name: 'contact_companies.index' },
              gate: 'contact_company_access'
            },
            {
              title: 'cruds.contactContact.title',
              icon: 'fas fa-user-plus',
              path: { name: 'contact_contacts.index' },
              gate: 'contact_contact_access'
            }
          ]
        },
        {
          title: 'cruds.faqManagement.title',
          icon: 'table_view',
          path: { name: 'faq_management' },
          gate: 'faq_management_access',
          children: [
            {
              title: 'cruds.faqCategory.title',
              icon: 'table_view',
              path: { name: 'faq_categories.index' },
              gate: 'faq_category_access'
            },
            {
              title: 'cruds.faqQuestion.title',
              icon: 'table_view',
              path: { name: 'faq_questions.index' },
              gate: 'faq_question_access'
            }
          ]
        },
        {
          title: 'cruds.course.title',
          icon: 'table_view',
          path: { name: 'courses.index' },
          gate: 'course_access'
        },
        {
          title: 'cruds.lesson.title',
          icon: 'table_view',
          path: { name: 'lessons.index' },
          gate: 'lesson_access'
        },
        {
          title: 'cruds.test.title',
          icon: 'table_view',
          path: { name: 'tests.index' },
          gate: 'test_access'
        },
        {
          title: 'cruds.question.title',
          icon: 'table_view',
          path: { name: 'questions.index' },
          gate: 'question_access'
        },
        {
          title: 'cruds.questionOption.title',
          icon: 'table_view',
          path: { name: 'question_options.index' },
          gate: 'question_option_access'
        },
        {
          title: 'cruds.testResult.title',
          icon: 'table_view',
          path: { name: 'test_results.index' },
          gate: 'test_result_access'
        },
        {
          title: 'cruds.testAnswer.title',
          icon: 'table_view',
          path: { name: 'test_answers.index' },
          gate: 'test_answer_access'
        },
        {
          title: 'cruds.expenseManagement.title',
          icon: 'account_balance_wallet',
          path: { name: 'expense_management' },
          gate: 'expense_management_access',
          children: [
            {
              title: 'cruds.expenseCategory.title',
              icon: 'table_view',
              path: { name: 'expense_categories.index' },
              gate: 'expense_category_access'
            },
            {
              title: 'cruds.incomeCategory.title',
              icon: 'table_view',
              path: { name: 'income_categories.index' },
              gate: 'income_category_access'
            },
            {
              title: 'cruds.expense.title',
              icon: 'table_view',
              path: { name: 'expenses.index' },
              gate: 'expense_access'
            },
            {
              title: 'cruds.income.title',
              icon: 'table_view',
              path: { name: 'incomes.index' },
              gate: 'income_access'
            },
            {
              title: 'cruds.expenseReport.title',
              icon: 'table_view',
              path: { name: 'expense_reports.index' },
              gate: 'expense_report_access'
            }
          ]
        }
      ]
    }
  }
}
</script>
