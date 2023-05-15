<?php

namespace DB;

use InvalidArgumentException;
use PDO;
use PDOException;
use Util\GenericConstsUtil;

class MySQL
{
    private object $db;

    /**
     * MySQL constructor.
     */
    public function __construct()
    {
        $this->db = $this->setDB();
    }

    public function setDB()
    {
        try {
            return new PDO(
                'mysql:host=' . HOST . '; dbname=' . DATABASE . ';', USER, PASSWORD
            );
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage());
        }
    }

    public function delete($table, $id)
    {
        $queryDelete = 'DELETE FROM ' . $table . ' WHERE id = :id';
        if ($table && $id) {
            $this->db->beginTransaction();

            $stmt = $this->db->prepare($queryDelete);
            $stmt->bindParam(':id', $id);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $this->db->commit();
                return GenericConstsUtil::MSG_SUCCESS_DELETED;
            }

            $this->db->rollBack();

            throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NO_RETURN);
        }
        throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_GENERIC);
    }

    public function getAll($table)
    {
        if ($table) {
            $query = 'SELECT * FROM ' . $table;
            $stmt = $this->db->query($query);
            $records = $stmt->fetchAll($this->db::FETCH_ASSOC);

            if (is_array($records) && count($records) > 0) {
                return $records;
            }
        }
        throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NO_RETURN);
    }

    public function getOneByKey($table, $id)
    {
        if ($table && $id) {
            $query = 'SELECT * FROM ' . $table . ' WHERE id = :id';
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            $totalRecords = $stmt->rowCount();

            if ($totalRecords === 1) {
                return $stmt->fetch($this->db::FETCH_ASSOC);
            }

            throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_NO_RETURN);
        }

        throw new InvalidArgumentException(GenericConstsUtil::MSG_ERROR_REQUIRED_ID);
    }

    public function getDb()
    {
        return $this->db;
    }
}