<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\AppReleases;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AppReleasesController extends Controller
{
    public function load()
    {
        $releases = AppReleases::orderBy('created_at', 'desc')->get();
        return response()->json([
            'releases' => $releases
        ], 200);
    }

    public function create(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'version' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1999'],
                'type' => ['required', 'string', 'max:255'],
            ]);

            $entryID = AppReleases::create([
                'title' => $data['title'],
                'version' => $data['version'],
                'description' => $data['description'],
                'type' => $data['type'],
            ])->id;
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'entry_id' => $entryID,
            'message' => 'Entry has been created.'
        ], 200);
    }

    public function update(Request $request)
    {
        try {
            $data = $request->validate([
                'id' => ['required', 'numeric'],
                'title' => ['required', 'string', 'max:255'],
                'version' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string', 'max:1999'],
                'type' => ['required', 'string', 'max:255'],
            ]);

            AppReleases::find($data['id'])->update([
                'title' => $data['title'],
                'version' => $data['version'],
                'description' => $data['description'],
                'type' => $data['type'],
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Entry has been updated.'
        ], 200);
    }

    public function delete($id)
    {
        try {
            if(!$id) throw new Exception('ID is required.');
            AppReleases::find((int) $id)->delete();
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 422);
        }

        return response()->json([
            'message' => 'Entry has been deleted.'
        ], 200);
    }
}
