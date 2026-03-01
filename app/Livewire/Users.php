<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;

class Users extends Component
{
    public $users;
    public $branches;

    public $showModal = false;

    public $name;
    public $username;
    public $password;
    public $role = 'manager';
    public $branch_id;
    public $phone;

    protected $rules = [
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username',
        'password' => 'required|min:6',
        'role' => 'required',
        'branch_id' => 'required|exists:branches,id',
        'phone' => 'required|string|max:255|unique:users,phone',

    ];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->users = User::whereIn('role', ['manager', 'accountant'])->with('branch')->get();
        $this->branches = Branch::all();
    }

    public function openModal()
    {
        $this->resetFields();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->username = '';
        $this->password = '';
        $this->role = 'manager';
        $this->branch_id = null;
        $this->phone = '';
    }

    public function saveUser()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'role' => $this->role,
            'branch_id' => $this->branch_id,
            'phone' => $this->phone,
        ]);

        $this->closeModal();
        $this->loadData();
        return redirect()->route('users')->with('success', __('messages.users.success_create'));
    }

    public function deleteUser($id)
    {
        User::findOrFail($id)->delete();
        $this->loadData();
        return redirect()->route('users')->with('success',  __('messages.users.success_delete'));
    }

    public function render()
    {
        return view('livewire.users');
    }
}
