![ERD](image.png)

需求:
老師 : 建立預約課程
學生 : 預約課程(有點數限制，初次登入送3點)  指定老師  意見反饋  推薦課程  課程取消(有時限，超時不退點)

Route:
teacher/index(後端主頁)(is_teacher, auth)
teacher/create(建立預約課程)(is_teacher, auth)
student/index (推薦算法?)
student/search(指定老師)
student/comment(意見反饋)(auth)
student/reserve(預約課程)(auth)
student/cancel (課程取消，判斷預約時間，超過不退點數)(auth)

**User**
- id
- name
- password
- email
- points
- role_id(roles)(M2O)

**Role**
- id
- name:teacher, student

**Course**
- id
- name
- teacher_id(users)(M2O)
- start_time

**Reservation**
- id
- student_id(users)(M2O)
- course_id(courses)(M2O)
- created_at

**Comment**
- id
- message
- student_id(users)(O2O)
- course_id(users)(O2O)
- created_at

**Tag**
- id
- name

**course_tage**
- course_id(courses)(M2O)
- tag_id(tags)(M2O)