<?php
/**
 * Kontroler odpowiedzialny za uzyskanie listy wpisów na blogu
 * @author Michał
 *
 */
class Start extends Controller
{
	
	/**
	 * Strona startowa
	 */
	public function index()
	{
		$this->_view = new View('strona');
		
		$posty = '';
		$wpis = new Wpis();
		$wpisy = $wpis->getAllWpisy();
		
		foreach($wpisy as $row)
		{
			$posty .= '
			<div class="post">
				<h2 class="title">'.$row['title'].'</h2>

				<p class="meta"><span class="date">'.date("Y-m-d",$row['data_dodania']).'</span><span class="posted">Napisał Michał</a></span></p>
				<div style="clear: both;">&nbsp;</div>
				<div class="entry">
					'.nl2br($row['tresc']).'
				</div>
			</div>';
		}
		
		
		$this->_view->add('posty',$posty);
		
		echo $this->_view->load();
	}
}