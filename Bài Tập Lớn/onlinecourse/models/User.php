<?php
require_once __DIR__ . '/../config/Database.php';

class User
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
    }

    public function getStudentCount()
    {
        $sql = 'SELECT COUNT(*) as count FROM users WHERE role = 2';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function getInstructorCount()
    {
        $sql = 'SELECT COUNT(*) as count FROM users WHERE role = 1';
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int)$result['count'];
    }

    public function findByEmailOrUsername($identifier)
    {
        $sql = 'SELECT * FROM users WHERE email = :id OR username = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $identifier]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id)
    {
        $sql = 'SELECT * FROM users WHERE id = :id LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = 'INSERT INTO users (username, email, password, fullname, role, status, bio, specialization, experience, education, avatar, other, social_provider, social_id, created_at) 
                VALUES (:username, :email, :password, :fullname, :role, :status, :bio, :specialization, :experience, :education, :avatar, :other, :social_provider, :social_id, NOW())';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            ':username' => $data['username'],
            ':email' => $data['email'],
            ':password' => $data['password'],
            ':fullname' => $data['fullname'],
            ':role' => isset($data['role']) ? (int)$data['role'] : 0,
            ':status' => $data['status'] ?? 1,
            ':bio' => $data['bio'] ?? '',
            ':specialization' => $data['specialization'] ?? '',
            ':experience' => $data['experience'] ?? '',
            ':education' => $data['education'] ?? '',
            ':avatar' => $data['avatar'] ?? '',
            ':other' => $data['other'] ?? '',
            ':social_provider' => $data['social_provider'] ?? '',
            ':social_id' => $data['social_id'] ?? ''
        ]);
    }

    public function getAll()
    {
        $sql = 'SELECT * FROM users ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUsername($username)
    {
        $sql = 'SELECT * FROM users WHERE username = :username LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findByEmail($email)
    {
        $sql = 'SELECT * FROM users WHERE email = :email LIMIT 1';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail($email) {
        return $this->findByEmail($email);
    }

    public function delete($id)
    {
        $sql = 'DELETE FROM users WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    public function update($id, $data)
    {
        $fields = [];
        $params = [':id' => $id];
        
        foreach ($data as $key => $value) {
            $fields[] = "$key = :$key";
            $params[":$key"] = $value;
        }
        
        $sql = 'UPDATE users SET ' . implode(', ', $fields) . ' WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute($params);
    }
    
    public function updateAvatar($id, $avatarPath)
    {
        $sql = 'UPDATE users SET avatar = :avatar WHERE id = :id';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([':avatar' => $avatarPath, ':id' => $id]);
    }
    
    public function getInstructors()
    {
        $sql = 'SELECT * FROM users WHERE role = 1 ORDER BY created_at DESC';
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function findByOther($other)
    {
        try {
            error_log("User findByOther called with: " . $other);
            
            // Normalize the input link
            $normalizedInput = $this->normalizeSocialLink($other);
            error_log("Normalized input: " . $normalizedInput);
            
            // Get all users with non-empty other column
            $sql = 'SELECT * FROM users WHERE other IS NOT NULL AND other != ""';
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            error_log("Found " . count($users) . " users with non-empty other column");
            
            // Check each user's other column for match
            foreach($users as $user) {
                $normalizedStored = $this->normalizeSocialLink($user['other']);
                error_log("Checking stored: " . $user['other'] . " -> " . $normalizedStored);
                
                if ($normalizedInput === $normalizedStored || 
                    $this->isSimilarSocialLink($normalizedInput, $normalizedStored)) {
                    error_log("MATCH FOUND for user ID: " . $user['id']);
                    return $user;
                }
            }
            
            error_log("NO MATCH FOUND");
            return null;
        } catch (Exception $e) {
            error_log("Exception in findByOther: " . $e->getMessage());
            return null;
        }
    }
    
    private function normalizeSocialLink($link)
    {
        // Remove trailing slash
        $link = rtrim($link, '/');
        
        // Ensure https
        if (strpos($link, 'http://') === 0) {
            $link = 'https://' . substr($link, 7);
        } elseif (strpos($link, 'https://') !== 0) {
            $link = 'https://' . $link;
        }
        
        // Remove www for consistency
        $link = str_replace('https://www.', 'https://', $link);
        
        return $link;
    }
    
    private function isSimilarSocialLink($link1, $link2)
    {
        // Extract username/profile part from Facebook links
        if (strpos($link1, 'facebook.com') !== false && strpos($link2, 'facebook.com') !== false) {
            $profile1 = $this->extractFacebookProfile($link1);
            $profile2 = $this->extractFacebookProfile($link2);
            return $profile1 && $profile2 && $profile1 === $profile2;
        }
        
        // Extract username/profile part from Google links
        if (strpos($link1, 'google.com') !== false && strpos($link2, 'google.com') !== false) {
            $profile1 = $this->extractGoogleProfile($link1);
            $profile2 = $this->extractGoogleProfile($link2);
            return $profile1 && $profile2 && $profile1 === $profile2;
        }
        
        return false;
    }
    
    private function extractFacebookProfile($link)
    {
        // Extract profile from facebook.com/username or facebook.com/profile.php?id=123
        if (preg_match('/facebook\.com\/([^\/\?]+)/', $link, $matches)) {
            return $matches[1];
        }
        return null;
    }
    
    private function extractGoogleProfile($link)
    {
        // Extract profile from plus.google.com/+username or google.com/username
        if (preg_match('/(?:plus\.)?google\.com\/([^\/\?]+)/', $link, $matches)) {
            return $matches[1];
        }
        return null;
    }
}
