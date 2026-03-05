<?php

namespace App\Services;

use App\Repositories\UserAddressRepository;

class UserAddressService
{
    protected UserAddressRepository $UserAddressRepository;

    public function __construct(UserAddressRepository $UserAddressRepository)
    {
        $this->UserAddressRepository = $UserAddressRepository;
    }

    public function all($params = [])
    {
        return $this->UserAddressRepository->all($params);
    }

    public function search($params = [])
    {
        return $this->UserAddressRepository->search($params);
    }

    public function show($id)
    {
        return $this->UserAddressRepository->show($id);
    }

    // Các hàm tìm kiếm khác chuyển sang repository, service chỉ gọi lại
    public function findByEmail(string $email)
    {
        return $this->UserAddressRepository->findByEmail($email);
    }

    public function getByEmail($email)
    {
        return $this->UserAddressRepository->getByEmail($email);
    }


    public function store(array $data)
    {
        $data['user_id'] = auth()->id();
        if (!empty($data['is_default'])) {
            $this->UserAddressRepository->unsetDefaultForUser($data['user_id']);
        }
        return $this->UserAddressRepository->store($data);
    }

    public function update($id, array $data = [])
    {
        if (!empty($data['is_default'])) {
            $userId = auth()->id();
            $this->UserAddressRepository->unsetDefaultForUser($userId);
        }
        return $this->UserAddressRepository->update($id, $data);
    }

    public function destroy($id)
    {
        return $this->UserAddressRepository->destroy($id);
    }
}
