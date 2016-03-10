<?php

//use Illuminate\Database\Eloquent\ModelNotFoundException;

class HomeController extends \BaseController {

	protected $note;
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::check()) {

			//regenerate sessions after coming back so old session from before are replaced
			Session::regenerate();

			$note = Note::whereUser(Auth::user()->email)->first();

			$images = Image::where('user', Auth::user()->email)->get();

			$count = Image::where('user', Auth::user()->email)->get()->count();

			$data = array('notes' => $note,
					'user' =>  Auth::user()->email,
					'images' => $images,
					'count' => $count);

			return View::make('sessions.home')->with($data);
		}else{
			return Redirect::route('sessions.create'); //form
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$extensions = array('jpg', 'gif');
		$links = array();
		$input = Input::all();
		for ($i = 0; $i < count(Input::get('link')); $i++) {
			array_push($links, $input['link'][$i]);
		}
		Note::create([
				'user' => Input::get('user'),
				'note' => Input::get('note'),
				'tbd'  => Input::get('tbd'),
				'link' => serialize($links)
		]);

		if(isset($input['image'])) {
			if(getimagesize($input['image']) != 0) {
				$ext = Input::file('image')->getClientOriginalExtension();
				if(in_array($ext, $extensions)) {
					$image = file_get_contents($input['image']);
					Image::create ([
							'image_name' => Input::file('image')->getClientOriginalName(),
							'user' => Input::get('user'),
							'image' => $image,
							'ext' => $ext
					]);
				} else {
					return View::make('sessions.try_again');
				}
			} else {
				return View::make('sessions.try_again');
			}
		}

		return Redirect::route('home.index');
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
		$extensions = array('jpg', 'gif');
		$links = array();
		$input = Input::all();
		for ($i = 0; $i < count(Input::get('link')); $i++) {
			array_push($links, $input['link'][$i]);
		}

		if(!empty($_POST['delete'])) {
			// Loop to store and display values of individual checked checkbox.
			foreach ($_POST['delete'] as $selected) {
				Image::whereId($selected)->delete();
			}
		}

		if(isset($input['image'])) {
			if(getimagesize($input['image']) != 0) {
				$ext = Input::file('image')->getClientOriginalExtension();
				if(in_array($ext, $extensions)) {
					$image = file_get_contents($input['image']);
					Image::create ([
							'image_name' => Input::file('image')->getClientOriginalName(),
							'user' => Input::get('user'),
							'image' => $image,
							'ext' => $ext
					]);
				} else {
					return View::make('sessions.try_again');
				}
			} else {
				return View::make('sessions.try_again');
			}
		}

		$note = Note::find($id);

		$note->note = Input::get('note');
		$note->tbd = Input::get('tbd');
		$note->link = serialize($links);
		$note->save();


		return Redirect::route('home.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{

	}




}
