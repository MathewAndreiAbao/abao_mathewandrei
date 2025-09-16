<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

class Loan_Controller extends Controller {
    public function __construct() {
        parent::__construct();
        $this->call->model('Loan_Model');
        $this->call->library('form_validation');
    }

    public function read() {
        $data['loans'] = $this->Loan_Model->getAll();
        $this->call->view('index', $data);
    }

    public function createLoan() {
        $this->form_validation
            ->name('borrower_name')
                ->required()
                ->max_length(50)
            ->name('loan_amount')
                ->required()
                ->numeric()
                ->greater_than(0)
            ->name('interest_rate')
                ->required()
                ->numeric()
                ->greater_than_equal_to(0)
                ->less_than_equal_to(100);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->get_errors();
            setErrors($errors);
            redirect('/');
        } else {

            $borrower_name = filter_var($_POST['borrower_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $loan_amount = filter_var($_POST['loan_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $interest_rate = filter_var($_POST['interest_rate'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $this->Loan_Model->createLoan([
                'borrower_name' => $borrower_name,
                'loan_amount' => $loan_amount,
                'interest_rate' => $interest_rate,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            setMessage('success', 'Loan created successfully!');
            redirect('/');
        }
    }

    public function updateLoan($id) {
        $this->form_validation
            ->name('borrower_name')
                ->required()
                ->max_length(50)
            ->name('loan_amount')
                ->required()
                ->numeric()
                ->greater_than(0)
            ->name('interest_rate')
                ->required()
                ->numeric()
                ->greater_than_equal_to(0)
                ->less_than_equal_to(100);

        if ($this->form_validation->run() == FALSE) {
            $errors = $this->form_validation->get_errors();
            setErrors($errors);
            redirect('/');
        } else {
            $borrower_name = filter_var($_POST['borrower_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $loan_amount = filter_var($_POST['loan_amount'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $interest_rate = filter_var($_POST['interest_rate'], FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            $this->Loan_Model->updateLoan($id, [
                'borrower_name' => $borrower_name,
                'loan_amount' => $loan_amount,
                'interest_rate' => $interest_rate,
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            setMessage('success', 'Loan updated successfully!');
            redirect('/');
        }
    }

    public function deleteLoan($id) {
        $this->Loan_Model->deleteLoan($id);
        setMessage('danger', 'Loan deleted successfully!');
        redirect('/');
    }
}
?>
