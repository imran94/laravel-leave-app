</div>
<!--/fluid-row-->



<hr>

</div>
<!--/.fluid-container-->
</body>

<!-- external javascript -->

<script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- library for cookie management -->
<script src="js/jquery.cookie.js"></script>
<!-- calender plugin -->
<script src='bower_components/moment/min/moment.min.js'></script>
<script src='bower_components/fullcalendar/dist/fullcalendar.min.js'></script>
<!-- data table plugin -->
{{-- <script src='js/jquery.dataTables.min.js'></script> --}}

<!-- select or dropdown enhancer -->
<script src="bower_components/chosen/chosen.jquery.min.js"></script>
<!-- plugin for gallery image view -->
<script src="bower_components/colorbox/jquery.colorbox-min.js"></script>
<!-- notification plugin -->
<script src="js/jquery.noty.js"></script>
<!-- library for making tables responsive -->
<script src="bower_components/responsive-tables/responsive-tables.js"></script>
<!-- tour plugin -->
<script src="bower_components/bootstrap-tour/build/js/bootstrap-tour.min.js"></script>
<!-- star rating plugin -->
<script src="js/jquery.raty.min.js"></script>
<!-- for iOS style toggle switch -->
<script src="js/jquery.iphone.toggle.js"></script>
<!-- autogrowing textarea plugin -->
<script src="js/jquery.autogrow-textarea.js"></script>
<!-- multiple file upload plugin -->
<script src="js/jquery.uploadify-3.1.min.js"></script>
<!-- history.js for cross-browser state change on ajax -->
<script src="js/jquery.history.js"></script>
<!-- application script for Charisma demo -->
<script src="js/charisma.js"></script>
<!-- bootstrap datepicker -->
<script type="text/javascript" src="js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="js/bootstrap-datetimepicker.js"></script>
<script src="bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!--<script src="js/jquery.js"></script>-->
<!-- bootstrap color picker -->
<!-- Add Black List Modal Error -->
<script>
    $('#datepicker').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd',
    })
    $('#datepicker2').datepicker({
        autoclose: true,
        format: 'yyyy-mm-dd'
    })

    $(document).ready(function() {
        $('#overall').DataTable({
            "dom": '<"top"<"left-datatable"li><"right-datatable"f>><"overflow-x"rt><"bottom"p><"clear">'
        });
    });

    function onSelectBranch(selectedBranch) {
        let departmentSelect = document.getElementById("department");
        this.clearOptions(departmentSelect);
        let designationSelect = document.getElementById("designation");
        this.clearOptions(designationSelect);
        const url = `${location.origin}/api/branches/${selectedBranch.value}/departments`;
        this.populateOptions(departmentSelect, url, 'Department');
    }

    function onSelectDepartment(selectedDept) {
        let designationSelect = document.getElementById("designation");
        this.clearOptions(designationSelect);
        const url = `${location.origin}/api/departments/${selectedDept.value}/designations`;
        this.populateOptions(designationSelect, url, 'Designation');
    }

    async function populateOptions(selectionToPopulate, url, elementName) {
        selectionToPopulate.disabled = true;

        const response = await fetch(url);
        const options = await response.json();

        let firstOpt = document.createElement("option");
        firstOpt.value = '';
        firstOpt.textContent = `Select ${elementName}`;
        selectionToPopulate.appendChild(firstOpt);
        options.forEach(function(opt) {
            let child = document.createElement("option");
            child.value = opt.id;
            child.textContent = opt.name;
            selectionToPopulate.appendChild(child);
        });
        selectionToPopulate.disabled = false;
    }

    function clearOptions(selectionToClear) {
        while (selectionToClear.firstChild) {
            selectionToClear.firstChild.remove();
        }
    }

    function onSelectLeave(selectedLeaveId) {
        console.log("Selected leave: ", selectedLeaveId);

        let leaveSelect = document.getElementById("selectedUser");
        let availableSickLeaves = document.getElementById("availableSickLeaves");
        let availableAnnualLeaves = document.getElementById("availableAnnualLeaves");
        let availableOtherLeaves = document.getElementById("availableOtherLeaves");

        availableSickLeaves.disabled = true;
        availableAnnualLeaves.disabled = true;
        availableOtherLeaves.disabled = true;

        fetch(`${location.origin}/api/leaves/${selectedLeaveId}`)
            .then(response => response.json())
            .then(data => {
                availableSickLeaves.value = data.sickLeft;
                availableAnnualLeaves.value = data.annualLeft;
                availableOtherLeaves.value = data.otherLeft;

                availableSickLeaves.disabled = false;
                availableAnnualLeaves.disabled = false;
                availableOtherLeaves.disabled = false;
            });


    }
</script>

</html>
