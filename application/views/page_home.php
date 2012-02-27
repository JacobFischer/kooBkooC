<h1>Home</h1>
<p>Welcome!</p>
<?$this->load->helper('url');?>
<form name="search_bar" method="get" action="<?=base_url()?>/index.php/cookware/id/1">
  <table width="400" border="1" cellpadding="5">
    <tr>
      <td>
        <input type="hidden" name="dff_view" value="grid">
        Search:<input type="text" name="dff_keyword" size="30" maxlength="50"><input type="submit" value="Find">
      </td>
    </tr>
  </table>
</form>