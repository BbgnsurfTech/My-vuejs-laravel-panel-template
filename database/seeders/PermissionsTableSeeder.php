<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'user_management_access',
            ],
            [
                'id'    => 2,
                'title' => 'permission_create',
            ],
            [
                'id'    => 3,
                'title' => 'permission_edit',
            ],
            [
                'id'    => 4,
                'title' => 'permission_show',
            ],
            [
                'id'    => 5,
                'title' => 'permission_delete',
            ],
            [
                'id'    => 6,
                'title' => 'permission_access',
            ],
            [
                'id'    => 7,
                'title' => 'role_create',
            ],
            [
                'id'    => 8,
                'title' => 'role_edit',
            ],
            [
                'id'    => 9,
                'title' => 'role_show',
            ],
            [
                'id'    => 10,
                'title' => 'role_delete',
            ],
            [
                'id'    => 11,
                'title' => 'role_access',
            ],
            [
                'id'    => 12,
                'title' => 'user_create',
            ],
            [
                'id'    => 13,
                'title' => 'user_edit',
            ],
            [
                'id'    => 14,
                'title' => 'user_show',
            ],
            [
                'id'    => 15,
                'title' => 'user_delete',
            ],
            [
                'id'    => 16,
                'title' => 'user_access',
            ],
            [
                'id'    => 17,
                'title' => 'product_management_access',
            ],
            [
                'id'    => 18,
                'title' => 'product_category_create',
            ],
            [
                'id'    => 19,
                'title' => 'product_category_edit',
            ],
            [
                'id'    => 20,
                'title' => 'product_category_show',
            ],
            [
                'id'    => 21,
                'title' => 'product_category_delete',
            ],
            [
                'id'    => 22,
                'title' => 'product_category_access',
            ],
            [
                'id'    => 23,
                'title' => 'product_tag_create',
            ],
            [
                'id'    => 24,
                'title' => 'product_tag_edit',
            ],
            [
                'id'    => 25,
                'title' => 'product_tag_show',
            ],
            [
                'id'    => 26,
                'title' => 'product_tag_delete',
            ],
            [
                'id'    => 27,
                'title' => 'product_tag_access',
            ],
            [
                'id'    => 28,
                'title' => 'product_create',
            ],
            [
                'id'    => 29,
                'title' => 'product_edit',
            ],
            [
                'id'    => 30,
                'title' => 'product_show',
            ],
            [
                'id'    => 31,
                'title' => 'product_delete',
            ],
            [
                'id'    => 32,
                'title' => 'product_access',
            ],
            [
                'id'    => 33,
                'title' => 'basic_c_r_m_access',
            ],
            [
                'id'    => 34,
                'title' => 'crm_status_create',
            ],
            [
                'id'    => 35,
                'title' => 'crm_status_edit',
            ],
            [
                'id'    => 36,
                'title' => 'crm_status_show',
            ],
            [
                'id'    => 37,
                'title' => 'crm_status_delete',
            ],
            [
                'id'    => 38,
                'title' => 'crm_status_access',
            ],
            [
                'id'    => 39,
                'title' => 'crm_customer_create',
            ],
            [
                'id'    => 40,
                'title' => 'crm_customer_edit',
            ],
            [
                'id'    => 41,
                'title' => 'crm_customer_show',
            ],
            [
                'id'    => 42,
                'title' => 'crm_customer_delete',
            ],
            [
                'id'    => 43,
                'title' => 'crm_customer_access',
            ],
            [
                'id'    => 44,
                'title' => 'crm_note_create',
            ],
            [
                'id'    => 45,
                'title' => 'crm_note_edit',
            ],
            [
                'id'    => 46,
                'title' => 'crm_note_show',
            ],
            [
                'id'    => 47,
                'title' => 'crm_note_delete',
            ],
            [
                'id'    => 48,
                'title' => 'crm_note_access',
            ],
            [
                'id'    => 49,
                'title' => 'crm_document_create',
            ],
            [
                'id'    => 50,
                'title' => 'crm_document_edit',
            ],
            [
                'id'    => 51,
                'title' => 'crm_document_show',
            ],
            [
                'id'    => 52,
                'title' => 'crm_document_delete',
            ],
            [
                'id'    => 53,
                'title' => 'crm_document_access',
            ],
            [
                'id'    => 54,
                'title' => 'content_management_access',
            ],
            [
                'id'    => 55,
                'title' => 'content_category_create',
            ],
            [
                'id'    => 56,
                'title' => 'content_category_edit',
            ],
            [
                'id'    => 57,
                'title' => 'content_category_show',
            ],
            [
                'id'    => 58,
                'title' => 'content_category_delete',
            ],
            [
                'id'    => 59,
                'title' => 'content_category_access',
            ],
            [
                'id'    => 60,
                'title' => 'content_tag_create',
            ],
            [
                'id'    => 61,
                'title' => 'content_tag_edit',
            ],
            [
                'id'    => 62,
                'title' => 'content_tag_show',
            ],
            [
                'id'    => 63,
                'title' => 'content_tag_delete',
            ],
            [
                'id'    => 64,
                'title' => 'content_tag_access',
            ],
            [
                'id'    => 65,
                'title' => 'content_page_create',
            ],
            [
                'id'    => 66,
                'title' => 'content_page_edit',
            ],
            [
                'id'    => 67,
                'title' => 'content_page_show',
            ],
            [
                'id'    => 68,
                'title' => 'content_page_delete',
            ],
            [
                'id'    => 69,
                'title' => 'content_page_access',
            ],
            [
                'id'    => 70,
                'title' => 'contact_management_access',
            ],
            [
                'id'    => 71,
                'title' => 'contact_company_create',
            ],
            [
                'id'    => 72,
                'title' => 'contact_company_edit',
            ],
            [
                'id'    => 73,
                'title' => 'contact_company_show',
            ],
            [
                'id'    => 74,
                'title' => 'contact_company_delete',
            ],
            [
                'id'    => 75,
                'title' => 'contact_company_access',
            ],
            [
                'id'    => 76,
                'title' => 'contact_contact_create',
            ],
            [
                'id'    => 77,
                'title' => 'contact_contact_edit',
            ],
            [
                'id'    => 78,
                'title' => 'contact_contact_show',
            ],
            [
                'id'    => 79,
                'title' => 'contact_contact_delete',
            ],
            [
                'id'    => 80,
                'title' => 'contact_contact_access',
            ],
            [
                'id'    => 81,
                'title' => 'faq_management_access',
            ],
            [
                'id'    => 82,
                'title' => 'faq_category_create',
            ],
            [
                'id'    => 83,
                'title' => 'faq_category_edit',
            ],
            [
                'id'    => 84,
                'title' => 'faq_category_show',
            ],
            [
                'id'    => 85,
                'title' => 'faq_category_delete',
            ],
            [
                'id'    => 86,
                'title' => 'faq_category_access',
            ],
            [
                'id'    => 87,
                'title' => 'faq_question_create',
            ],
            [
                'id'    => 88,
                'title' => 'faq_question_edit',
            ],
            [
                'id'    => 89,
                'title' => 'faq_question_show',
            ],
            [
                'id'    => 90,
                'title' => 'faq_question_delete',
            ],
            [
                'id'    => 91,
                'title' => 'faq_question_access',
            ],
            [
                'id'    => 92,
                'title' => 'course_create',
            ],
            [
                'id'    => 93,
                'title' => 'course_edit',
            ],
            [
                'id'    => 94,
                'title' => 'course_show',
            ],
            [
                'id'    => 95,
                'title' => 'course_delete',
            ],
            [
                'id'    => 96,
                'title' => 'course_access',
            ],
            [
                'id'    => 97,
                'title' => 'lesson_create',
            ],
            [
                'id'    => 98,
                'title' => 'lesson_edit',
            ],
            [
                'id'    => 99,
                'title' => 'lesson_show',
            ],
            [
                'id'    => 100,
                'title' => 'lesson_delete',
            ],
            [
                'id'    => 101,
                'title' => 'lesson_access',
            ],
            [
                'id'    => 102,
                'title' => 'test_create',
            ],
            [
                'id'    => 103,
                'title' => 'test_edit',
            ],
            [
                'id'    => 104,
                'title' => 'test_show',
            ],
            [
                'id'    => 105,
                'title' => 'test_delete',
            ],
            [
                'id'    => 106,
                'title' => 'test_access',
            ],
            [
                'id'    => 107,
                'title' => 'question_create',
            ],
            [
                'id'    => 108,
                'title' => 'question_edit',
            ],
            [
                'id'    => 109,
                'title' => 'question_show',
            ],
            [
                'id'    => 110,
                'title' => 'question_delete',
            ],
            [
                'id'    => 111,
                'title' => 'question_access',
            ],
            [
                'id'    => 112,
                'title' => 'question_option_create',
            ],
            [
                'id'    => 113,
                'title' => 'question_option_edit',
            ],
            [
                'id'    => 114,
                'title' => 'question_option_show',
            ],
            [
                'id'    => 115,
                'title' => 'question_option_delete',
            ],
            [
                'id'    => 116,
                'title' => 'question_option_access',
            ],
            [
                'id'    => 117,
                'title' => 'test_result_create',
            ],
            [
                'id'    => 118,
                'title' => 'test_result_edit',
            ],
            [
                'id'    => 119,
                'title' => 'test_result_show',
            ],
            [
                'id'    => 120,
                'title' => 'test_result_delete',
            ],
            [
                'id'    => 121,
                'title' => 'test_result_access',
            ],
            [
                'id'    => 122,
                'title' => 'test_answer_create',
            ],
            [
                'id'    => 123,
                'title' => 'test_answer_edit',
            ],
            [
                'id'    => 124,
                'title' => 'test_answer_show',
            ],
            [
                'id'    => 125,
                'title' => 'test_answer_delete',
            ],
            [
                'id'    => 126,
                'title' => 'test_answer_access',
            ],
            [
                'id'    => 127,
                'title' => 'expense_management_access',
            ],
            [
                'id'    => 128,
                'title' => 'expense_category_create',
            ],
            [
                'id'    => 129,
                'title' => 'expense_category_edit',
            ],
            [
                'id'    => 130,
                'title' => 'expense_category_show',
            ],
            [
                'id'    => 131,
                'title' => 'expense_category_delete',
            ],
            [
                'id'    => 132,
                'title' => 'expense_category_access',
            ],
            [
                'id'    => 133,
                'title' => 'income_category_create',
            ],
            [
                'id'    => 134,
                'title' => 'income_category_edit',
            ],
            [
                'id'    => 135,
                'title' => 'income_category_show',
            ],
            [
                'id'    => 136,
                'title' => 'income_category_delete',
            ],
            [
                'id'    => 137,
                'title' => 'income_category_access',
            ],
            [
                'id'    => 138,
                'title' => 'expense_create',
            ],
            [
                'id'    => 139,
                'title' => 'expense_edit',
            ],
            [
                'id'    => 140,
                'title' => 'expense_show',
            ],
            [
                'id'    => 141,
                'title' => 'expense_delete',
            ],
            [
                'id'    => 142,
                'title' => 'expense_access',
            ],
            [
                'id'    => 143,
                'title' => 'income_create',
            ],
            [
                'id'    => 144,
                'title' => 'income_edit',
            ],
            [
                'id'    => 145,
                'title' => 'income_show',
            ],
            [
                'id'    => 146,
                'title' => 'income_delete',
            ],
            [
                'id'    => 147,
                'title' => 'income_access',
            ],
            [
                'id'    => 148,
                'title' => 'expense_report_create',
            ],
            [
                'id'    => 149,
                'title' => 'expense_report_edit',
            ],
            [
                'id'    => 150,
                'title' => 'expense_report_show',
            ],
            [
                'id'    => 151,
                'title' => 'expense_report_delete',
            ],
            [
                'id'    => 152,
                'title' => 'expense_report_access',
            ],
        ];

        Permission::insert($permissions);
    }
}
