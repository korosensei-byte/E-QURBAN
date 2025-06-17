<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Myth\Auth\Models\UserModel; // Import UserModel untuk mencari user

class Admin extends BaseController
{
    protected $db, $builder;
    protected $userModel; // Tambahkan properti untuk UserModel

    public function __construct()
    {
        $this->db         = \Config\Database::connect();
        $this->builder    = $this->db->table('users');
        $this->userModel  = new UserModel(); // Inisialisasi UserModel
    }

    public function index(): string
    {
        $data['title'] = 'Manajemen User';

        // Logika untuk pencarian dan filter
        $keyword = $this->request->getVar('keyword');
        $roleFilter = $this->request->getVar('role');

        $this->builder->select('users.id as userid, username, email, user_image, active, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');

        if ($keyword) {
            $this->builder->like('username', $keyword)
                          ->orLike('email', $keyword)
                          ->orLike('fullname', $keyword);
        }

        if ($roleFilter) {
            $this->builder->where('auth_groups.name', $roleFilter);
        }

        // Contoh paginasi (jika Anda ingin menggunakannya)
        // $usersPerPage = 20; // Jumlah user per halaman
        // $data['users'] = $this->builder->paginate($usersPerPage);
        // $data['pager'] = $this->builder->pager;

        // Tanpa paginasi, ambil semua hasil
        $query = $this->builder->get();
        $data['users'] = $query->getResultObject();

        return view('admin/index', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'Detail User';

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name, active'); // Tambahkan 'active'
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query      = $this->builder->get();

        $data['user']  = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin')->with('error', 'User tidak ditemukan.');
        }

        return view('admin/detail', $data);
    }

    // --- Contoh fungsionalitas admin lainnya (membutuhkan route dan view tambahan) ---

    // public function editRole($userId)
    // {
    //     // Logic to display form to edit user role
    //     // Requires: view admin/edit_role.php, form, update logic
    // }

    // public function updateRole()
    // {
    //     // Logic to process role update
    //     // Requires: validation, update to auth_groups_users table
    // }

    // public function delete($userId)
    // {
    //     // Logic to delete a user
    //     // Requires: confirmation, userModel->delete()
    // }
}