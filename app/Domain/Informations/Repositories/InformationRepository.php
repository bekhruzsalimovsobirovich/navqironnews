<?php

namespace App\Domain\Informations\Repositories;

use App\Domain\Informations\Models\Information;

class InformationRepository
{
    public function paginate($pagination, $filter)
    {
        return Information::query()
            ->Filter($filter)
            ->withTranslation()
            ->orderByTranslation('title')
            ->paginate($pagination);
    }


    public function getInformation($limit = 10, $orderBy = 'created_at', $direction = 'desc', $useTranslation = true)
    {
        $query = Information::query();

        if ($useTranslation) {
            $query->withTranslation()
                ->orderByTranslation('title');
        }

        return $query->orderBy($orderBy, $direction)
            ->limit($limit)
            ->get();
    }

    public function getEightGroupByCategoryInformation()
    {
        return Information::query()
            ->withTranslation()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(fn($information) => $information->category->name ?? 'Unknown')
            ->map(fn($group) => $group->take(8)); // Har bir kategoriya uchun faqat 8 ta elementni oling
    }

    public function getOtherInformations()
    {
        return Information::query()
            ->withTranslation()
            ->with('category')
            ->inRandomOrder()
            ->limit(8)
            ->get();
    }

    public function getCategoryInformation($pagination,$category_id)
    {
        return Information::query()
            ->withTranslation()
            ->where('category_id',$category_id)
            ->paginate($pagination);
    }

//    public function getThreeLatestInformation()
//    {
//        return Information::query()
//            ->withTranslation()
//            ->orderByTranslation('title') // Ensure this method is supported for translations
//            ->latest('created_at')        // Orders by created_at in descending order
//            ->limit(3)                    // Restrict to the latest three records
//            ->get();
//    }
//
//    public function getTenLatestInformation()
//    {
//        return Information::query()
//            ->withTranslation()
//            ->orderByTranslation('title') // Ensure this method is supported for translations
//            ->latest('created_at')        // Orders by created_at in descending order
//            ->limit(10)                    // Restrict to the latest three records
//            ->get();
//    }
//
//    public function getMoreReadInformation()
//    {
//        return Information::query()
//            ->withTranslation() // Agar tarjimalar kerak bo'lsa
//            ->orderBy('view_count', 'desc') // view_count ustuni bo'yicha kamayish tartibida tartiblash
//            ->limit(10) // Faqat 10 ta yozuvni cheklash
//            ->get();
//    }
}
