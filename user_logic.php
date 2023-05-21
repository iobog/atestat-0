<?php 

  function get_user_by_email_and_pass($user, $pass)
  {
    global $conn;
    global $user_table_name;

    $query = "
      SELECT * FROM $user_table_name
      WHERE username = ? AND password = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$user, $pass]);
    return $smt->fetch();
  }

  function get_user_by_email($user)
  {
    global $conn;
    global $user_table_name;

    $query = "
      SELECT * FROM $user_table_name
      WHERE username = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$user]);
    return $smt->fetch();
  }

  function get_user_by_id($id)
  {
    global $conn;
    global $user_table_name;

    $query = "
      SELECT * FROM $user_table_name
      WHERE id = ?
    ";
    $smt = $conn->prepare($query);
    $smt->execute([$id]);
    return $smt->fetch();
  }

  function create_user($user, $pass, $role = 'user')
  {
    global $conn;
    global $user_table_name;

    $query = "
      INSERT INTO $user_table_name(username, password, rol)
      VALUES (?, ?, ?)
    ";

    $smt = $conn->prepare($query);
    $smt->execute([$user, $pass, $role]);

    return $conn->lastInsertId();
  }