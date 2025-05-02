# 1. Mô tả Hệ thống

Hệ thống được xây dựng cho một cửa hàng chuyên kinh doanh xe ô tô với nhiều thương hiệu, kiểu dáng và màu sắc đa dạng – từ thiết kế trẻ trung đến mạnh mẽ. Các sản phẩm được cung cấp với mức giá hợp lý, phù hợp với nhiều nhóm khách hàng.

## Chức năng chính:

- **Duyệt và tìm kiếm sản phẩm**: 
  Người dùng có thể xem danh sách xe ô tô theo danh mục, kiểu dáng, màu sắc, hoặc từ khóa.

- **Giỏ hàng và đặt hàng**:
  - Người dùng có thể thêm sản phẩm vào giỏ hàng.
  - Để thực hiện mua hàng, người dùng cần đăng nhập vào hệ thống.

- **Quản lý tài khoản và đơn hàng**:
  - Người dùng có thể đăng ký, đăng nhập, cập nhật thông tin cá nhân.
  - Có thể theo dõi lịch sử và trạng thái đơn hàng của mình.

- **Thông báo qua email**:
  - Khi đơn hàng được xác nhận, hệ thống sẽ gửi email thông báo để khách hàng có thể theo dõi đơn hàng một cách thuận tiện và bảo mật.

- **Phân quyền người dùng**:
  - Hệ thống hỗ trợ quản lý vai trò người dùng theo mô hình RBAC (Role-Based Access Control).
  - Các vai trò bao gồm:
    - Manager: Quản lý toàn hệ thống.
    - Dev: Quản lý kỹ thuật và phát triển.
    - Content: Quản lý nội dung sản phẩm.
    - User: Người dùng thông thường (khách hàng).

## Tính năng bảo mật:
- Thông tin đăng nhập (mật khẩu) được mã hóa.
- Xác thực người dùng trước khi thao tác giỏ hàng và thanh toán.
- Dữ liệu được lưu trữ an toàn và hỗ trợ phiên làm việc cho các lần đăng nhập tiếp theo.

# 2. Thiết kế Cơ sở Dữ liệu

+ users: id, name, email, password,created_at, updated_at
+ roles : id, name, note,created_at, updated_at
+ user_role : user_id, role_id,created_at, updated_at
+ permissions : id, name, note,created_at, updated_at
+ role_permission : role_id, permission_id,created_at, updated_at
+ categories :  id, title, slug, image, category_id,created_at, updated_at
+ products : id, title, keyword, description, body, image, price, category_id, user_id, created_at, updated_at
+ orders : id, title,user_id, status, created_at, updated_at
+ order_details :  id, order_id, product_id, title, image, quantity, price, total, created_at, updated_at
+ carts:  id, user_id, product_id, quantity, created_at, updated_at

## 1. users
- **Mục đích**: Lưu thông tin người dùng.
- **Các cột**:
  - id: Khóa chính.
  - name: Tên người dùng.
  - email: Email người dùng (nên unique).
  - password: Mật khẩu đã mã hóa (hash).
  - created_at, updated_at: Thời gian tạo và cập nhật bản ghi.
- **Ghi chú**: Mật khẩu phải được hash để đảm bảo bảo mật.

---

## 2. roles
- **Mục đích**: Lưu vai trò (quyền hạn) của người dùng, ví dụ: admin, editor, user.
- **Các cột**:
  - id, name, note, created_at, updated_at.

---

## 3. user_role
- **Mục đích**: Bảng trung gian để liên kết nhiều-nhiều giữa users và roles.
- **Các cột**:
  - user_id, role_id, created_at, updated_at.
- **Quan hệ**:
  - Một người dùng có thể có nhiều vai trò.
  - Một vai trò có thể gán cho nhiều người dùng.

---

## 4. permissions
- **Mục đích**: Lưu các quyền cụ thể, ví dụ: create_post, edit_user, delete_order.
- **Các cột**:
  - id, name, note, created_at, updated_at.

---

## 5. role_permission
- **Mục đích**: Bảng trung gian để gán nhiều quyền cho vai trò.
- **Các cột**:
  - role_id, permission_id, created_at, updated_at.
- **Quan hệ**:
  - Một vai trò có thể có nhiều quyền.
  - Một quyền có thể được gán cho nhiều vai trò.

---

## 6. categories
- **Mục đích**: Quản lý danh mục sản phẩm (hỗ trợ danh mục cha-con).
- **Các cột**:
  - id, title, slug, image, category_id, created_at, updated_at.
- **Quan hệ**:
  - category_id cho phép danh mục con liên kết đến danh mục cha (self-referencing).

---

## 7. products
- **Mục đích**: Lưu thông tin sản phẩm.
- **Các cột**:
  - id, title, keyword, description, body, image, price, category_id, user_id, created_at, updated_at.
- **Quan hệ**:
  - category_id: liên kết đến categories.
  - user_id: người dùng tạo sản phẩm (nếu có tính năng multi-vendor hoặc quản lý theo user).

---

## 8. orders
- **Mục đích**: Lưu thông tin đơn hàng.
- **Các cột**:
  - id, title, user_id, status, created_at, updated_at.
- **Quan hệ**:
  - Mỗi đơn hàng thuộc về một người dùng (user_id).
  - Một đơn hàng có nhiều dòng chi tiết (order_details).

---

## 9. order_details
- **Mục đích**: Lưu chi tiết từng sản phẩm trong đơn hàng.
- **Các cột**:
  - id, order_id, product_id, title, image, quantity, price, total, created_at, updated_at.
- **Ghi chú**:
  - Trường title, image, price lưu snapshot thông tin sản phẩm tại thời điểm đặt hàng để tránh bị thay đổi nếu sản phẩm gốc thay đổi.

---

## 10. carts
- **Mục đích**: Lưu thông tin giỏ hàng của người dùng.
- **Các cột**:
  - id, user_id, product_id, quantity, created_at, updated_at.
- **Quan hệ**:
  - Một người dùng có thể có nhiều sản phẩm trong giỏ hàng.
  - Mỗi sản phẩm có số lượng (quantity).

---

## 11. Ghi chú chung
- Tất cả các bảng đều có trường created_at và updated_at để theo dõi thời điểm tạo và cập nhật.
- Các quan hệ nên được định nghĩa rõ bằng **foreign keys** trong quá trình migration (nếu dùng framework như Laravel).
- Cân nhắc tạo **index** trên các cột liên kết như user_id, role_id, category_id, order_id, product_id để tối ưu truy vấn.
