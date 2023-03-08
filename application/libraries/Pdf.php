<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * CodeIgniter PDF Library
 *
 * Generate PDF's in your CodeIgniter applications.
 *
 * @package			CodeIgniter
 * @subpackage		Libraries
 * @category		Libraries
 * @author			Chris Harvey
 * @license			MIT License
 * @link			https://github.com/chrisnharvey/CodeIgniter-PDF-Generator-Library
 */

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

use Dompdf\Dompdf;

class Pdf extends DOMPDF
{
	/**
	 * Get an instance of CodeIgniter
	 *
	 * @access	protected
	 * @return	void
	 */
	protected function ci()
	{
		return get_instance();
	}

	/**
	 * Load a CodeIgniter view into domPDF
	 *
	 * @access	public
	 * @param	string	$view The view to load
	 * @param	array	$data The view data
	 * @return	void
	 */
	public function load_view($view, $data = array())
	{

				if($data['file'] != 'soa')
				{
						$file_name = 'invoice.pdf';
				}
				else
				{
						$file_name = 'soa.pdf';
				}

        // Load content from html file
        $html = $this->ci()->load->view($view, $data, TRUE);
        // $html = file_get_contents("pdf-content.html");
        $this->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $this->setPaper('A4', 'potrait');

        // Render the HTML as PDF
        $this->render();

         $output = $this->output();
        file_put_contents('assets/'.$file_name, $output);
        // Output the generated PDF (1 = download and 0 = preview)
        // $this->stream("Invoice", array("Attachment" => 0));
				// $customer_id = 1;
			 // $this->stream("".$customer_id.".pdf", array("Attachment"=>0));

	}
}
