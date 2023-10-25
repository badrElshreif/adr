<?php

namespace App\Page\Domain\Services;

use App\Infrastructure\Domain\Payloads\GenericPayload;
use App\Infrastructure\Domain\Services\Service;
use App\Infrastructure\Exceptions\ModelNotFoundException;
use App\Page\Domain\Models\Page;
use App\Property\Domain\Models\Property;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class CreatePageService extends Service
{
    public function handle($data = [])
    {
        try {
            // Begin Transaction
            DB::beginTransaction();

            $Page = Page::create($data);

            DB::commit();

            return new GenericPayload($Page, Response::HTTP_CREATED);

        }
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $ex)
        {
            // Rollback Transaction
            DB::rollback();
            throw new ModelNotFoundException;
        }
        catch (\Illuminate\Database\QueryException $ex)
        {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }
        catch (\PDOException $ex)
        {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                $ex->getMessage(), 422
            );
        }
        catch (\Exception $ex)
        {
            // Rollback Transaction
            DB::rollback();

            return new GenericPayload(
                $ex->getTrace(), 422
            );
        }

    }

    private function saveProperties($product, $properties)
    {
        $properties_arr = [];

        foreach ($properties as $property)
        {

            if (isset($property['value']) && $property['value'] != '')
            {
                $prop                           = Property::whereId($property['property_id'])->firstOrFail();
                $property['property_option_id'] = null;

                if ($prop->propertyType->has_options == 1)
                {
                    $option                         = \App\Property\Domain\Models\PropertyOption::findOrFail($property['value']);
                    $property['property_option_id'] = $option->id;
                    $property['value']              = null;
                }

                array_push($properties_arr, [
                    'property_id'        => $property['property_id'],
                    'value'              => $property['value'],
                    'property_option_id' => $property['property_option_id']
                ]);
            }

        }

        //dd($properties_arr);
        $product->properties()->sync($properties_arr);
    }

}
