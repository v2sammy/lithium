<?php session_start(); ?>
<div id="groupsWrapper" class="wrapper">
	<div id="myGroupsAlert" style="display:none;"></div>
	<legend> <span id="groupLegend">My Groups</span> 
		<form class="form-search pull-right">
  			<div class="input-append">
    				<input type="text" id="txtSearchGroup" class="span2 search-query" data-provide="typeahead" placeholder="Search Public Groups" >
    				<button class="btn" id="btnSearchGroup">Search</button>
  			</div>  			
		</form>
		<a href="#mymodal" title="Create new group" style="font-size : 16px;margin-right : 20px;" class="pull-right" data-toggle="modal" data-target="#myModal"> Create New </a>
	</legend>
	<div id="groupsList">
	<?php
		foreach($groups as $group)
		{
			$exists = null;
			$isMember = '0';
	?>
			<div class="listDiv">
	<?php
			echo "<a id='".$group['_id']."' href='' class='publicGroup' data-name='".$group['group_name']."'>".$group['group_name']."</a>";
			if($group['owner'] == $_SESSION['loggedInUserId'])
			{
				echo "<span class='label label-inverse' style='margin-left : 30px;'> Owner </span>";
				echo "<button class='btn pull-right btnDeleteGroup' title='Delete' style='margin-left : 30px;' id='".$group['_id']."'> <i class='icon-trash'> </i> </button>"; 
				echo "<button class='btn pull-right btnEditGroup' title='Edit' style='margin-left : 30px;' id='".$group['_id']."'> <i class='icon-edit'> </i></button>"; 
				
			}
			else
			{				
				}
			
			if($group['visibility'] == "public")
			{
				echo "<span class='label ' style='margin-left : 30px;'> Public </span>";
			}
			else if($group['visibility'] == "private")
			{
				echo "<span class='label' style='margin-left : 30px;'> Private </span>";
			}
			else
			{
			
			}
			
			foreach($group['users'] as $member)
			{
				if($member['id'] == $_SESSION['loggedInUserId'])
				{
					$isMember = '1';
					break;
				}
			}			
			if($group['visibility'] != 'private'){
				if($isMember == '1')
				{
					echo "<span class='label' style='margin-left : 30px;'> Member </span>";
					echo "<button class='btn btn-success pull-right btnUnjoinPublicGroup' style='margin-left : 30px;' id='".$group['_id']."'> Unjoin </button>"; 
				}
				else
				{
					echo "<button class='btn btn-success pull-right btnJoinPublicGroup' style='margin-left : 30px;' id='".$group['_id']."'> Join </button>"; 
				}
				$isMember = '0';
			}
			?>			
			</div> <!-- end listDiv div -->
	<?php
		}
	?>
	</div> <!-- end groupsList div-->
</div> <!-- end groupsWrapper div -->

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Create New Group</h3>
  </div>
  <div class="modal-body">
    <form id="frmNewGroup" class="frmNewGroup">
    				<input type="text" id="txtGroupName" class="txtGroupName" placeholder="Create New Group" style="display : block;" />
    				<input type="submit" class="btn btn-success" data-dismiss="modal" aria-hidden="true" value="Create" />
    </form>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
  </div>
</div>
