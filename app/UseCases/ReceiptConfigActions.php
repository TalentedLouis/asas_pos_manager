<?php

namespace App\UseCases;

use App\Http\Requests\ReceiptConfigRequest;
use App\Models\ReceiptConfig;
use App\Repositories\ReceiptConfigRepositoryInterface;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ReceiptConfigActions
{
    private ReceiptConfigRepositoryInterface $repository;

    /**
     * @param ReceiptConfigRepositoryInterface $repository
     */
    public function __construct(ReceiptConfigRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return ReceiptConfig|null
     */
    public function getOne(): ?ReceiptConfig
    {
        return $this->repository->getOne();
    }

    public function create($post)
    {
        $entity = $this->repository->newEntity();
        $this->update($entity, $post);
    }

    /**
     * @param ReceiptConfig $entity
     * @param ReceiptConfigRequest $post
     * @return bool
     */
    public function update(
        ReceiptConfig $entity,
        ReceiptConfigRequest $post
    ): bool {
        $entity->name = $post->name;
        $entity->address = $post->address;
        $entity->telephone = $post->telephone;
        $entity->text_1 = $post->text_1;
        $entity->text_2 = $post->text_2;
        $entity->text_3 = $post->text_3;
        $entity->text_4 = $post->text_4;
        $entity->text_5 = $post->text_5;
        $entity->shop_id = Auth::user()->shop->id;
        // delete s3.

        if (
            (!empty($entity->header_image) && empty($post->header_image)) ||
            (!empty($entity->header_image) && !empty($post->header_image_file))
        ) {
            Storage::disk('s3')->delete($entity->header_image);
        }

        // put s3.
        $fileName = '';
        if ($post->header_image_file) {
            $fileName = Storage::disk('s3')->put(
                '/img',
                $post->header_image_file,
                'public'
            );
        } else {
            if ($post->header_image) {
                $fileName = $post->header_image;
            }
        }
        $entity->header_image = $fileName;

        // footer image
        // delete s3.
        if (
            (!empty($entity->footer_image) && empty($post->footer_image)) ||
            (!empty($entity->footer_image) && !empty($post->footer_image_file))
        ) {
            Storage::disk('s3')->delete($entity->footer_image);
        }
        // put s3.
        $fileName = '';
        if ($post->footer_image_file) {
            $fileName = Storage::disk('s3')->put(
                '/img',
                $post->footer_image_file,
                'public'
            );
        } else {
            if ($post->footer_image) {
                $fileName = $post->footer_image;
            }
        }
        $entity->footer_image = $fileName;

        return $this->repository->save($entity);
    }

    public function delete(ReceiptConfig $entity): ?bool
    {
        return $this->repository->delete($entity);
    }
}
