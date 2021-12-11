<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RequestStorePegawai extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nama' => 'required',
            'alamat' => 'required',
            'hp' => 'required',
            'username' => 'required|unique:pegawai',
            'password' => 'required|min:8|',
            'password_confirmation' => 'required|min:8|same:password'
        ];
    }

    public function messages()
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'alamat.required' => 'Alamat wajib diisi.',
            'hp.required' => 'Password wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah terdaftar.',
            'password_confirmation.same' => 'Password konfirmasi tidak sama.',
            'password_confirmation.required' => 'Password konfirmasi wajib diisi'
        ];
    }
}
