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
    $data['title'] = 'User Detail';

    // Ambil semua data grup/role yang ada
    $groupModel = new \Myth\Auth\Models\GroupModel();
    $data['all_roles'] = $groupModel->findAll();

    // Ambil data user yang spesifik (dari tabel users)
    $this->builder->select('users.id as userid, username, email, fullname, user_image, created_at');
    $this->builder->where('users.id', $id);
    $query = $this->builder->get();
    $data['user'] = $query->getRow();

    // Jika user tidak ditemukan, kembali ke halaman daftar user
    if (empty($data['user'])) {
        return redirect()->to('/admin');
    }

    // --- BAGIAN YANG DIPERBAIKI ---
    // Ambil role yang dimiliki user saat ini menggunakan query join
    // Ini adalah cara yang benar, bukan $userObject->getGroups()
    $userGroups = $groupModel
        ->select('auth_groups.id, auth_groups.name')
        ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id')
        ->where('auth_groups_users.user_id', $id)
        ->findAll();

    $data['user_roles'] = $userGroups;
    // --- AKHIR BAGIAN YANG DIPERBAIKI ---

    // Kirim semua data ke view
    return view('admin/detail', $data);
}

public function updateUserRoles($id)
{
    // Model yang diperlukan
    // PERHATIKAN: Kita akan menggunakan $groupModel untuk memanipulasi role,
    // karena fungsi add/remove user dari grup ada di sini.
    $groupModel = new \Myth\Auth\Models\GroupModel();

    // 1. Dapatkan role ID baru dari form.
    $newRoles = $this->request->getPost('roles') ?? [];

    // 2. Dapatkan role ID yang dimiliki pengguna saat ini.
    $currentUserGroups = $groupModel
        ->select('auth_groups.id')
        ->join('auth_groups_users', 'auth_groups_users.group_id = auth_groups.id')
        ->where('auth_groups_users.user_id', $id)
        ->findAll();
    $currentUserRoleIds = array_column($currentUserGroups, 'id');

    // 3. Logika Sinkronisasi:
    //    a. Cari role yang harus DITAMBAHKAN
    $rolesToAdd = array_diff($newRoles, $currentUserRoleIds);
    if (!empty($rolesToAdd)) {
        foreach ($rolesToAdd as $roleId) {
            // --- PERBAIKAN DI SINI ---
            // Panggil fungsi dari $groupModel, bukan $userModel
            $groupModel->addUserToGroup($id, $roleId);
        }
    }

    //    b. Cari role yang harus DIHAPUS
    $rolesToRemove = array_diff($currentUserRoleIds, $newRoles);
    if (!empty($rolesToRemove)) {
        foreach ($rolesToRemove as $roleId) {
            // --- PERBAIKAN DI SINI ---
            // Panggil fungsi dari $groupModel, bukan $userModel
            $groupModel->removeUserFromGroup($id, $roleId);
        }
    }

    // 4. Siapkan pesan sukses dan kembalikan ke halaman detail
    session()->setFlashdata('message', 'Roles pengguna berhasil diperbarui.');
    return redirect()->to('/admin/' . $id);
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