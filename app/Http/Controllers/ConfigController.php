<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConfigRequest;
use App\Http\Requests\CreateTeacherRequest;
use App\Http\Requests\UpdateTeacherRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Flash;
use Response;
use Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;

class ConfigController extends AppBaseController
{
     /**
     * Display a listing of the Config.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $configs = collect(config('system'));
        $noConfigs = 1;
        return view('backend.configs.index',compact('configs','noConfigs'));
    }

    /**
     * Show the form for creating a new Config.
     *
     * @return Response
     */
    public function create()
    {
        $config = ["name"=>null,'value'=>null];
        return view('backend.configs.create',compact('config'));
    }

    /**
     * Store a newly created Config.
     *
     * @param ConfigRequest $request
     *
     * @return Response
     */
    public function store(ConfigRequest $request)
    {
        $configs = config('system');
        $input = $request->all();
        $key = str_slug($input['name']);
        $configs[$key] = ['name'=>$input['name'],'value'=>$input['value']];
        $data = var_export($configs, 1);
        if(File::put(config_path().'/system.php', "<?php\n return $data ;")) {
            Flash::success(__('messages.created'));
            return redirect(route('admin.configs.index'));
        }
    }

    /**
     * Display the specified Config.
     *
     * @param  int $key
     *
     * @return Response
     */
    public function show($key)
    {
        $config = collect(config('system.'.$key));
        if(empty($config)){
            Flash::error(__('messages.not-found'));
            return view('backend.configs.index');
        }
        return view('backend.configs.show',compact('key','config'));
    }

    /**
     * Show the form for editing the specified Config.
     *
     * @param  int $key
     *
     * @return Response
     */
    public function edit($key)
    {
        $config = config('system.'.$key);

        if(empty($config)){
            Flash::error(__('messages.not-found'));
            return view('backend.configs.index');
        }
        return view('backend.configs.edit',compact('key','config'));
    }

    /**
     * Update the specified Config.
     *
     * @param  int              $key
     * @param UpdateTeacherRequest $request
     *
     * @return Response
     */
    public function update($key, ConfigRequest $request)
    {
        $config = config('system.'.$key);

        if (empty($config)) {
            Flash::error(__('messages.no-items'));

            return redirect(route('admin.configs.index'));
        }

        $configs = config('system');
        $input = $request->all();
        $configs[$key] = ['name'=>$input['name'],'value'=>$input['value']];
        $data = var_export($configs, 1);
        if(File::put(config_path().'/system.php', "<?php\n return $data ;")) {
            Flash::success(__('messages.updated'));
            return redirect(route('admin.configs.index'));
        }

        return redirect(route('admin.configs.index'));
    }

    /**
     * Remove the specified Config.
     *
     * @param  int $key
     *
     * @return Response
     */
    public function destroy($keyRemove,Request $request)
    {
        if ($keyRemove == 'MULTI') {
            $configs = config('system');
            foreach ($request->ids as $id) {
//                dd($id);
                $config = config('system.'.$id);
                if (empty($config)) {
                    Flash::error(__('messages.no-items'));
                    return redirect(route('admin.configs.index'));
                }
                unset($configs[$id]);
            }
            $data = var_export($configs, 1);
            File::put(config_path().'/system.php', "<?php\n return $data ;");
            Flash::success(__('messages.deleted'));
            return redirect(route('admin.configs.index'));
        }
        else {
            $config = config('system.'.$keyRemove);
            if (empty($config)) {
                Flash::error(__('messages.no-items'));

                return redirect(route('admin.configs.index'));
            }
            $configs = config('system');
            unset($configs[$keyRemove]);
            $data = var_export($configs, 1);
            if(File::put(config_path().'/system.php', "<?php\n return $data ;")) {
                Flash::success(__('messages.deleted'));
                return redirect(route('admin.configs.index'));
            }
            Flash::success(__('messages.deleted'));

            return redirect(route('admin.configs.index'));
        }
    }
}
