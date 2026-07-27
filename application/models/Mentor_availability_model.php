<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mentor_availability_model extends CI_Model {

    public function get_by_mentor($mentor_id) {
        return $this->db
            ->where('mentor_id', $mentor_id)
            ->order_by('day_of_week, start_time')
            ->get('mentor_availability')
            ->result();
    }

    public function get_available_slots($mentor_id, $date = null) {
        $day_of_week = $date ? date('w', strtotime($date)) : null;
        $this->db->where('mentor_id', $mentor_id);
        $this->db->where('is_booked', 0);
        if ($date) {
            $this->db->group_start();
            $this->db->where('day_of_week', $day_of_week);
            $this->db->or_where('date_override', $date);
            $this->db->group_end();
        }
        $this->db->order_by('start_time');
        return $this->db->get('mentor_availability')->result();
    }

    public function get_by_id($id) {
        return $this->db->get_where('mentor_availability', array('id' => $id))->row();
    }

    public function create($data) {
        $this->db->insert('mentor_availability', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('mentor_availability', $data);
    }

    public function delete($id) {
        return $this->db->where('id', $id)->delete('mentor_availability');
    }

    public function mark_booked($id, $booking_id) {
        return $this->db->where('id', $id)->update('mentor_availability', array(
            'is_booked' => 1,
            'booking_session_id' => $booking_id,
        ));
    }

    public function mark_available($id) {
        return $this->db->where('id', $id)->update('mentor_availability', array(
            'is_booked' => 0,
            'booking_session_id' => null,
        ));
    }

    public function get_week_slots($mentor_id) {
        $slots = $this->db->where('mentor_id', $mentor_id)->where('is_booked', 0)->order_by('day_of_week, start_time')->get('mentor_availability')->result();
        $week = array_fill(0, 7, array());
        foreach ($slots as $slot) {
            $dow = $slot->day_of_week;
            if ($dow === null && $slot->date_override !== null) {
                $dow = date('w', strtotime($slot->date_override));
            }
            if ($dow !== null) {
                $week[$dow][] = $slot;
            }
        }
        return $week;
    }
}
