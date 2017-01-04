<?php
App::uses('Folder', 'Utility');

/**
 *
 * CakePHP (version 2) CakeFolder Library
 * Auto create folder if not found
 *
 * @author Hahuy <admin@hahuy.com>
 *
 */

class CakeFolder extends Folder {

/**
 * Create a directory structure recursively.
 *
 * Can be used to create deep path structures like `/foo/bar/baz/shoe/horn`
 *
 * @param string $pathname The directory structure to create. Either an absolute or relative
 *   path. If the path is relative and exists in the process' cwd it will not be created.
 *   Otherwise relative paths will be prefixed with the current pwd().
 * @param int $mode octal value 0755
 * @return bool Returns TRUE on success, FALSE on failure
 * @link http://book.cakephp.org/2.0/en/core-utility-libraries/file-folder.html#Folder::create
 */
	public function create($pathname, $mode = false, $recursive = true) {
		if (is_dir($pathname) || empty($pathname)) {
			return true;
		}

		if (!self::isAbsolute($pathname)) {
			$pathname = self::addPathElement($this->pwd(), $pathname);
		}

		if (!$mode) {
			$mode = $this->mode;
		}

		if (is_file($pathname)) {
			$this->_errors[] = __d('cake_dev', '%s is a file', $pathname);
			return false;
		}
		$pathname = rtrim($pathname, DS);
		$nextPathname = substr($pathname, 0, strrpos($pathname, DS));

		if ($this->create($nextPathname, $mode, $recursive)) {
			if (!file_exists($pathname)) {
				$old = umask(0);
				if (mkdir($pathname, $mode, $recursive)) {
					umask($old);
					$this->_messages[] = __d('cake_dev', '%s created', $pathname);
					return true;
				}
				umask($old);
				$this->_errors[] = __d('cake_dev', '%s NOT created', $pathname);
				return false;
			}
		}
		return false;
	}
}