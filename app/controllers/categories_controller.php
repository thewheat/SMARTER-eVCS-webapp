<?php
class CategoriesController extends AppController {

	var $name = 'Categories';

	function index2($id){
		$files = scandir(DIR);
		foreach($files as $file)
		{
						
		}
		
		if ($handle = opendir(DIR)) 
		{
			echo "Directory handle: $handle\n";
			echo "Files:\n";
			
			/* This is the correct way to loop over the directory. */
			while (false !== ($file = readdir($handle))) 
			{
				echo "$file\n<BR>";
			}
			
			/* This is the WRONG way to loop over the directory. */
			while ($file = readdir($handle)) 
			{
				echo "$file\n";
			}
		}
		
		closedir($handle);
	}
	function index($id = null) {
	
	
		if($id == null) $id = 0;
		$searchArr = array();
		$searchArr['Category.parent_category_id'] = $id;
		$this->Category->recursive = 0;
		$this->paginate = array(
			'conditions' => $searchArr
			, 'order' => array('Category.order' => 'asc'),
		);
		$categories = $this->paginate('Category');
		$parents = array();
		if($id != 0)
		{
			$selected = $this->Category->read(null, $id);
			$tmp = $selected;
			$count = 0;
			while(isset($tmp['Category']['parent_category_id']) && $tmp['Category']['parent_category_id'] != 0)
			{
				$count++;
				if ($count > 100) break;
				$searchArr = array();
				$searchArr['Category.id'] = $id;
				$tmp = $this->Category->read(null, $tmp['Category']['parent_category_id']);
				array_unshift($parents, $tmp);
			}
		}
		$this->set(compact('selected', 'categories', 'parents'));		
		
	}

	function index_all($id = null) {
		$this->Category->recursive = 0;
		$this->set('categories', $this->paginate('Category'));
		$this->render('index');
	}

	function main($id = null) {
		if($id == null) $id = 0;
		$selected = null;
		if($id != 0) $selected = $this->Category->read(null, $id);
		
		
		# select children items
		$categories = $this->Category->find('all', 
			array('conditions' => 
				array('Category.parent_category_id' => $id,
				),
				'order' => 'Category.order asc'
			)
		);
		
print_r($selected);
		$next = array();
		// if a sequential category is selected
		if($selected != null && $selected['Category']['type'] == 1)
		{
			// if no childrens exist, so show sequence of items (i.e. all items have same parents, order by `order`)
			if(count($categories) == 0)
			{
				$categories = $this->Category->find('all', 
					array('conditions' => 
						array(
							'Category.parent_category_id' => $selected['Category']['parent_category_id'],
							'Category.type' => 1,
							'Category.order >' => $selected['Category']['order'],
						),
						'order' =>
						array(
							'Category.order' => 'asc'
						),
					)
				);
				
				$next = $this->Category->find('all', 
					array('conditions' => 
						array(
							'Category.parent_category_id' => $selected['Category']['parent_category_id'],
							'Category.type' => 1,
							'Category.order > ' => $selected['Category']['order'],
						),
						'order' =>
						array(
							'Category.order' => 'asc'
						),
					)
				);
				$next = @$next[0];
				
				$count = 0;
				while(count($next) == 0)
				{
					$count++;
					if ($count > 10) break;
					$parent = $this->Category->read(null, $selected['Category']['parent_category_id']);
					$next = $this->Category->find('all', 
						array('conditions' => 
							array(
								'Category.parent_category_id' => $parent['Category']['parent_category_id'],
								'Category.type' => 1,
								'Category.order > ' => $parent['Category']['order'],
							),
							'order' =>
							array(
								'Category.order' => 'asc'
							),
						)
					);
					$next = @$next[0];
				}

			}
			else // sequential and has children. meaning is the first in the sequence
			{
				$next = $categories[0];
			}
		}
		$this->set(compact('selected', 'categories', 'next', 'id'));		
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('category', $this->Category->read(null, $id));
	}

	function add($id = null) {
		if($id == null) $id = '';

		if (!empty($this->data)) 
		{
			$error = false;
			$errMsg = "";
			# check if directory exists. if not create
			if(!is_dir(DIR . $this->data['Category']['parent_category_id']))
			{
				if(!mkdir(DIR . $this->data['Category']['parent_category_id']))
				{
					$error = true;
					$errMsg .= "Cannot create directory to store files in\n";
				}
			}
			


			$upload_vars = array('image', 'voice_question', 'voice_answer');
			$uploaded = array();
			foreach($upload_vars as $upload_var)
			{
				$uploaded[$upload_var] = false;
				if(!$error && is_uploaded_file($this->data['Category'][$upload_var]['tmp_name']))
				{
					$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category'][$upload_var]['name']);
					if(move_uploaded_file($this->data['Category'][$upload_var]['tmp_name'], $filename))
					{
						$this->data['Category'][$upload_var] = basename($filename);
						$uploaded[$upload_var] = true;
					}
					else
					{
						$error = true;
						$errMsg .= "Cannot copy file to necessary location\n";
					}
				}
				else
				{
					$this->data['Category'][$upload_var] = '';
				}
			}
			
/*			
			if(!$error && is_uploaded_file($this->data['Category']['image']['tmp_name']))
			{
				$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category']['image']['name']);
				if(move_uploaded_file($this->data['Category']['image']['tmp_name'], $filename))
				{
					$this->data['Category']['image'] = basename($filename);
				}
				else
				{
					$error = true;
					$errMsg .= "Cannot copy file to necessary location\n";
				}
			}
			else
			{
				$this->data['Category']['image'] = '';
			}
			
			if(!$error && is_uploaded_file($this->data['Category']['voice']['tmp_name']))
			{
				$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category']['voice']['name']);
				if(move_uploaded_file($this->data['Category']['voice']['tmp_name'], $filename))
				{
					$this->data['Category']['voice'] = basename($filename);
				}
				else
				{
					$error = true;
					$errMsg .= "Cannot copy file to necessary location\n";
					
				}
			}
			else
			{
				$this->data['Category']['voice'] = '';
			}
			//*/
			
			if($error)
			{
				$this->Session->setFlash($errMsg);
			}
			else
			{
				$this->Category->create();
				//*
				if($this->data['Category']['order'] == "") $this->data['Category']['order'] = 0;
				if ($this->Category->save($this->data)) 
				{
					$this->Session->setFlash(__('The category has been saved', true));
					$this->redirect(array('action' => 'index', $this->data['Category']['parent_category_id']));
				}
				else 
				{
					$error = true;
					$errMsg = "The category could not be saved. Please, try again";
				}
			}
		}
		$parentCategories = $this->Category->ParentCategory->find('list');

		$this->set(compact('parentCategories', 'id'));
		
/*
Array ( 
		[Category] => Array ( 
				[parent_category_id] => 0 
				[name] => 
				[text] => 23 
				[image] => 
				[voice] => 
				[order] => 
				[type] => 0 
				[image1] => Array ( 
					[name] => DST APN.png 
					[type] => image/png 
					[tmp_name] => /private/var/tmp/phpu0ZNSP 
					[error] => 0 
					[size] => 67916 
					) 
				) 
			)
*/		
	}
	function profile()
	{
		if($this->data['Profile']['delete_image'])
			unlink(DIR . "/profile.jpg");
		if(is_uploaded_file($this->data['Profile']['image']['tmp_name']))
		{
			unlink(DIR . "/profile.jpg");
			$filename = $this->__generate_file_name(DIR, "/profile.jpg");
			if(move_uploaded_file($this->data['Profile']['image']['tmp_name'], $filename))
			{
				$this->Session->setFlash(__('Profile Picture updated', true));
			}
			else
			{
				$this->Session->setFlash(__('Could not delete', true));
			}
		}
		else
		{
		}	
		$this->redirect(array('action' => 'index'));
	}
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid category', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->Category->recursive = 0;
			$oldData = $this->Category->read(null, $id);;
			
			$error = false;
			$errMsg = "";
		
			# check if directory exists. if not create
			if(!is_dir(DIR . $this->data['Category']['parent_category_id']))
			{
				if(!mkdir(DIR . $this->data['Category']['parent_category_id']))
				{
					$error = true;
					$errMsg .= "Cannot create directory to store files in\n";
				}
			}
			
			$upload_vars = array('image', 'voice_question', 'voice_answer');
			foreach($upload_vars as $upload_var)
			{
				$uploaded_new = false;
				if($this->data['Category']['delete_current_' . $upload_var] || $uploaded_new)
					unlink(DIR . "/" . $oldData['Category']['parent_category_id'] . "/" . $oldData['Category'][$upload_var]);
				if(!$error && is_uploaded_file($this->data['Category'][$upload_var]['tmp_name']))
				{
					$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category'][$upload_var]['name']);
					if(move_uploaded_file($this->data['Category'][$upload_var]['tmp_name'], $filename))
					{
						$this->data['Category'][$upload_var] = basename($filename);
						$uploaded_new = true;
					}
					else
					{
						$error = true;
						$errMsg .= "Cannot copy file to necessary location\n";
					}
				}
				else
				{
					if($this->data['Category']['delete_current_' . $upload_var])
						$this->data['Category'][$upload_var] = '';
					else
						$this->data['Category'][$upload_var] = $oldData['Category'][$upload_var];
				}
			}
			
			
			/*
			$uploadedImage = false;
			if(!$error && is_uploaded_file($this->data['Category']['image']['tmp_name']))
			{
				$uploadedImage = true;
				$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category']['image']['name']);
				if(move_uploaded_file($this->data['Category']['image']['tmp_name'], $filename))
				{
					$this->data['Category']['image'] = basename($filename);
				}
				else
				{
					$error = true;
					$errMsg .= "Cannot copy file to necessary location\n";
				}
			}
			else
			{
				$this->data['Category']['image'] = '';
			}
			
			$uploadedVoice = false;
			if(!$error && is_uploaded_file($this->data['Category']['voice']['tmp_name']))
			{
				$uploadedVoice = true;
				$filename = $this->__generate_file_name(DIR . $this->data['Category']['parent_category_id'], $this->data['Category']['voice']['name']);
				if(move_uploaded_file($this->data['Category']['voice']['tmp_name'], $filename))
				{
					$this->data['Category']['voice'] = basename($filename);
				}
				else
				{
					$error = true;
					$errMsg .= "Cannot copy file to necessary location\n";
					
				}
			}
			else
			{
				$this->data['Category']['voice'] = '';
			}
			*/
			
			//*
			//*/
			
			if($error)
			{
				$this->Session->setFlash($errMsg);
			}
			else
			{
				$this->Category->create();
				//*
				if($this->data['Category']['order'] == "") $this->data['Category']['order'] = 0;
				if ($this->Category->save($this->data)) 
				{
					$this->Session->setFlash(__('The category has been saved', true));
					$this->redirect(array('action' => 'index', $this->data['Category']['parent_category_id']));
				}
				else 
				{
					$error = true;
					$errMsg = "The category could not be saved. Please, try again";
				}
			}		
		}
		if (empty($this->data)) {
			$this->data = $this->Category->read(null, $id);
		}
		$parentCategories = $this->Category->ParentCategory->find('list');
		$this->set(compact('parentCategories'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for category', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Category->delete($id)) {
			$this->Session->setFlash(__('Category deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Category was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function export($id = 0){
		$export_data = $this->__gather_export_data($id);

echo "<PRE>";
echo DIR_EXPORT . "<BR>";
		$this->__generate_export_data($export_data, DIR_EXPORT);
echo "</PRE>";

		$this->Session->setFlash(__('Export done', true));
	}
	function __generate_export_data($export_data, $dir) {
		$dir = trim($dir);
		if($dir[strlen($dir)-1] != "/")  $dir .= "/";

		$dir_export = trim(DIR_EXPORT);
		if($dir_export[strlen($dir_export)-1] != "/")  $dir_export .= "/";
		if ($dir == $dir_export)
		{
			# export profile image and sounds
			$this->__rrmdir($dir . "sounds");
			$this->__rrmdir($dir . "images");
			$this->__rrmdir($dir . "custom");
			mkdir($dir . "sounds");
			mkdir($dir . "images");
			mkdir($dir . "custom");
			chmod($dir . "sounds", 0777);
			chmod($dir . "images", 0777);
			chmod($dir . "custom", 0777);
			
			$dir_src = trim(DIR);
			if($dir_src[strlen($dir_src)-1] != "/")  $dir_src .= "/";
			$src_file = $dir_src . "audio_yes.mp3";
			$dest_file = $dir . "sounds/audio_yes.mp3";
			copy($src_file, $dest_file); 
			chmod($dest_file, 0777);
			$src_file = $dir_src . "audio_no.mp3";
			$dest_file = $dir . "sounds/audio_no.mp3";
			copy($src_file, $dest_file);
			chmod($dest_file, 0777);
			$src_file = $dir_src . "profile.jpg";
			$dest_file = $dir . "images/profile.jpg";
			copy($src_file, $dest_file); 
			chmod($dest_file, 0777);

			
			$dir .= "custom/";
		}

		$count = 0;
		$num_files = count($export_data);
		foreach($export_data as $data)
		{
			$count++;
			$subdir = "";
			for($i = 0; $i + strlen($count . "") < strlen($num_files . ""); $i++)
			{
				$subdir .= "0";
			}
			// save image			
			$dest_file_prefix = $dir. $subdir . $count;
			
			$src_dir = DIR;
			$src_dir = trim($src_dir);
			if($src_dir[strlen($src_dir)-1] != "/")  $src_dir .= "/";
			$src_dir .= $data['Category']['parent_category_id'] . "/";


			$copy_arr = array();
			$copy_arr['image'] = '.jpg';
			$copy_arr['voice'] = 'v.mp3';
			$copy_arr['voice_question'] = 'vq.mp3';
			$copy_arr['voice_answer'] = 'va.mp3';
			foreach($copy_arr as $var => $val)
			{
				$src_file = $src_dir . $data['Category'][$var];
				$dest_file = $dest_file_prefix . $val;
				if(is_file($src_file))
				{
					if (!copy($src_file, $dest_file)) 
					{
						echo "failed to copy $src_file...<BR>";
					}
					else
					{
						chmod($dest_file, 0777);
					}
				}
			}
			file_put_contents($dest_file_prefix . ".txt", $data['Category']['text']);
			chmod($dest_file_prefix . ".txt", 0777);
			// save text
			// save audio
			if (count($data['children']) > 0)
			{
				mkdir($dest_file_prefix);
				chmod($dest_file_prefix, 0777);
				
				$this->__generate_export_data($data['children'], $dir . $subdir . $count);
			}
		}		
	}
	
	function __rrmdir($dir) 
	{ 
		if (is_dir($dir)) 
		{ 
			$objects = scandir($dir); 
			foreach ($objects as $object) 
			{ 
				if ($object != "." && $object != "..") 
				{ 
					if (filetype($dir."/".$object) == "dir") $this->__rrmdir($dir."/".$object); else unlink($dir."/".$object); 
				} 
			} 
			reset($objects); 
			rmdir($dir); 
		} 
	} 	
	
	function __gather_export_data($id = null) {
		if($id == null) $id = 0;
		$selected = null;
		if($id != 0) $selected = $this->Category->read(null, $id);
		
		
		# select children items
		$this->Category->recursive = -1;
		$categories = $this->Category->find('all', 
			array('conditions' => 
				array('Category.parent_category_id' => $id,
				),
				'order' => 'Category.order asc'
			)
		);
			#echo "!- " . $id . "<BR>";

			for($i = 0; $i < count($categories); $i++)
			{
			#echo " -- " . $categories[$i]['Category']['id'] . "<BR>";
				$categories[$i]['children'] = $this->__gather_export_data($categories[$i]['Category']['id']);
			}
		return $categories;
	}	
}

/*
notes
	html5
		mp3
			Yes		Chrome 
			No		Firefox
					Opera
					Chromium
	flash
		wont play back on if javascript tries to start playment onload (ok if you click button to play)
			Chrome
			Chromium
			Safari
*/
?>