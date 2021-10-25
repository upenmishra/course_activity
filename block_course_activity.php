<?php
// This file is part of Moodle - http://moodle.org/.
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.

/* 
 * Version details
 *
 * @package    block_course_activity
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
 class block_course_activity extends block_base{
    function init(){
        $this->title = get_string('pluginname','block_course_activity');
    }
    function get_content(){
        global $CFG, $DB, $USER, $OUTPUT;
        $this->content = new stdClass();
        $this->content->text = "upen";
        
        $mods = get_course_mods($this->page->course->id);
        //print_object($mods);
        $texthtml = "<ul>";
        foreach($mods as $cmk=>$cm) {
            if (\core_availability\info_module::is_user_visible($cm, $USER->id)) {
               $modrec = $DB->get_record($cm->modname, array('id' => $cm->instance));
               $actComp = $DB->get_record('course_modules_completion', array('coursemoduleid'=>$cmk, 'userid'=>$USER->id));
               echo $act_comp_status = ($actComp==1 ? ' - Completed' : '');
               $texthtml .= "<li><a href='view.php?id=2#section-".$cm->section."'>".$cmk." - ".$modrec->name." - ".date('d-M-Y',$cm->added)."</a>".$act_comp_status."</li>"; 
            }
        }
        $texthtml .= "</ul>";
        $this->content->text = $texthtml;
        $this->content->footer = '';
    }
 }