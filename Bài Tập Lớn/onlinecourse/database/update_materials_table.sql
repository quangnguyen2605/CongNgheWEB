-- Update materials table to support both course-level and lesson-level materials

-- Add course_id column if it doesn't exist
ALTER TABLE materials 
ADD COLUMN IF NOT EXISTS course_id INT NULL AFTER lesson_id;

-- Add description column if it doesn't exist  
ALTER TABLE materials 
ADD COLUMN IF NOT EXISTS description TEXT NULL AFTER file_type;

-- Add uploaded_at column if it doesn't exist
ALTER TABLE materials 
ADD COLUMN IF NOT EXISTS uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;

-- Add foreign key constraint for course_id if it doesn't exist
ALTER TABLE materials 
ADD CONSTRAINT IF NOT EXISTS fk_materials_course 
FOREIGN KEY (course_id) REFERENCES courses(id) ON DELETE CASCADE;

-- Add indexes for better performance
CREATE INDEX IF NOT EXISTS idx_course_id ON materials(course_id);
CREATE INDEX IF NOT EXISTS idx_lesson_id ON materials(lesson_id);

-- Show the updated table structure
DESCRIBE materials;
