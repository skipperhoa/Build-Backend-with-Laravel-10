## GIT TIP
1️⃣ Xem TẤT CẢ các nhánh (local + remote)
🔹 Nhánh local
```bash
git branch
```
Example:
```bash
$ git branch
* main
```

🔹 Nhánh remote (trên GitHub)
```bash
git branch -r
```
Example:
```bash
$ git branch -r
  origin/HEAD -> origin/main
  origin/cicd_nodejs_react
  origin/develop
  origin/main
  origin/nodejs_react
  origin/origin/nodejs_react
```

🔹 Xem cả hai (hay dùng nhất)
```bash
git branch -a
```
Example:
```bash
$ git branch -a
* main
  remotes/origin/HEAD -> origin/main
  remotes/origin/cicd_nodejs_react
  remotes/origin/develop
  remotes/origin/main
  remotes/origin/nodejs_react
  remotes/origin/origin/nodejs_react
```
2️⃣ Chuyển sang nhánh khác
🔹 Nhánh đã tồn tại local
```bash
git switch dev
```
hoặc (cách cũ)
```bash
git checkout dev
```
🔹 Nhánh CHỈ có trên remote (chưa có local)
```bash
git switch -c dev origin/dev
```
👉 Lệnh này:

- tạo nhánh local dev

- tracking với origin/dev

3️⃣ Xem nhánh đang track remote nào

```bash
git branch -vv
```
Example:
```bash
$ git branch -vv
* main 3f9c779 [origin/main] Add frontend workflow trigger to main
```

4️⃣ Xóa nhánh (khi không dùng nữa)
🔹 Xóa nhánh local
```bash
git branch -d feature/docker
```

🔹 Xóa nhánh remote

```bash
git push origin --delete feature/docker
```
5️⃣ Quy trình chuẩn khi repo nhiều nhánh (khuyên dùng)
```bash
git checkout main
git pull

git switch dev
git pull

git switch -c feature/login
```
Làm xong:
```bash
git push -u origin feature/login
```
6️⃣ Gợi ý theo repo của bạn (Next.js + Docker)

Nhìn cấu trúc:

- docker-compose-dev.yml
- docker-compose-prod.yml
- .github/workflows

👉 Rất có thể flow là:

- main → production

- dev → staging

- feature/* → làm tính năng

👉 KHÔNG code trực tiếp trên main ❌

-----
✅ Cách lấy code từ remotes/origin/nodejs_react để sửa & push lại
🔹 BƯỚC 1: Tạo nhánh local từ nhánh remote
```bash
git switch -c nodejs_react origin/nodejs_react
```
📌 Lệnh này sẽ:

- Tạo nhánh local nodejs_react

- Checkout sang nhánh đó

- Tự động track origin/nodejs_react

🔹 BƯỚC 2: Kiểm tra lại
```bash
git branch -vv
```
Bạn sẽ thấy:
```bash
* nodejs_react  abc1234 [origin/nodejs_react] ...
  main          3f9c779 [origin/main] ...
```
➡️ OK, nhánh đã được link đúng 👌

🔹 BƯỚC 3: Sửa code bình thường
```bash
code .
# hoặc sửa file bằng editor bạn dùng
```
🔹 BƯỚC 4: Commit thay đổi
```bash
git status
git add .
git commit -m "Update config for nodejs react"
```

🔹 BƯỚC 5: Push lại lên GitHub
```bash
git push origin nodejs_react
```
➡️ Vì nhánh đã tracking sẵn, có thể dùng gọn hơn:
```bash
git push
```

⚠️ LƯU Ý QUAN TRỌNG
❌ ĐỪNG checkout nhánh remote kiểu này
```bash
git checkout origin/nodejs_react ❌
```
→ sẽ vào detached HEAD, không push được

🧠 Mẹo chuyên nghiệp
🔹 Nếu muốn tạo nhánh mới từ nodejs_react
```bash
git switch -c feature/fix-docker nodejs_react
git push -u origin feature/fix-docker
```
-------------
TRƯỜNG HỢP LỠ CHECKOUT NHANH TRÊN REMOTE MÀ DƯỚI LOCAL CHƯA CÓ

❓ Detached HEAD là gì (nói ngắn gọn)

Khi bạn chạy:
```bash
git checkout origin/nodejs_react
```
Git sẽ:
- Checkout một commit cụ thể

- ❌ KHÔNG đứng trên nhánh nào

- → gọi là detached HEAD

- Commit vẫn được, nhưng push thì không biết push vào nhánh nào

🧯 CÁCH CỨU KHI LỠ CHECKOUT origin/nodejs_react
🔹 TRƯỜNG HỢP 1: Bạn CHƯA sửa gì

👉 Cách đơn giản nhất
```bash
git switch -c nodejs_react origin/nodejs_react
```

✔️ Tạo nhánh local đúng chuẩn
✔️ Thoát detached HEAD
✔️ Không mất gì

🔹 TRƯỜNG HỢP 2: Bạn ĐÃ sửa code nhưng CHƯA commit

👉 Vẫn cứu được
```bash
git switch -c nodejs_react
```

📌 Git sẽ:

Tạo nhánh mới từ commit hiện tại

Giữ nguyên toàn bộ file bạn đã sửa

Sau đó:
```bash       
git status
git add .
git commit -m "Fix something"
git push -u origin nodejs_react
```

🔹 TRƯỜNG HỢP 3: Bạn ĐÃ commit trong detached HEAD (nguy hiểm nhất 😅)

👉 Vẫn cứu được nếu chưa reset

1️⃣ Xem commit bạn vừa tạo
```bash
git log --oneline -5
```

Giả sử thấy:
```bash
abc1234 Fix docker config
```
2️⃣ Tạo nhánh từ commit đó
```bash
git branch nodejs_react abc1234
git switch nodejs_react
```
3️⃣ Push lên GitHub
```bash
git push -u origin nodejs_react
```
✔️ Commit sống lại hoàn toàn


🚨 ĐIỀU TUYỆT ĐỐI KHÔNG LÀM

❌ Đừng chạy:
```bash
git reset --hard
```

❌ Đừng đóng terminal nếu chưa tạo branch
→ commit có thể bị Git GC xóa

🧠 Mẹo tránh detached HEAD vĩnh viễn
✅ Luôn dùng
```bash
git switch -c ten_nhanh origin/ten_nhanh
```
❌ Tránh
```bash
git checkout origin/ten_nhanh
```

🔍 Kiểm tra mình có đang bị detached không?
```bash
git status
```
Nếu thấy:
```bash
HEAD detached at origin/nodejs_react
```
→ đang bị ❗

-------------
🎯 MỤC TIÊU

Nhánh cũ: nodejs_react (đã tồn tại trên remote)

Nhánh mới: fix/docker (làm việc tạm)

Cuối cùng: push code về nodejs_react

🧩 BƯỚC 1: Checkout nhánh CŨ (làm nguồn)
```bash
git checkout nodejs_react
git pull
```

📌 Đảm bảo:
Local = remote
Không conflict

🧩 BƯỚC 2: Tạo nhánh MỚI từ nhánh CŨ
```bash
git switch -c fix/docker
```

📌 Lúc này:
```
fix/docker
   ↑
nodejs_react
```

🧩 BƯỚC 3: Code & commit trên nhánh MỚI
```bash
git status
git add .
git commit -m "Fix docker config"
```
🧩 BƯỚC 4: Đẩy code NGƯỢC về nhánh CŨ

CÁCH 1 (KHUYẾN NGHỊ – RÕ RÀNG)
```bash
git checkout nodejs_react
git pull
git merge fix/docker
```

Nếu OK:
```bash
git push origin nodejs_react
```
CÁCH 2 (GỌN – hay dùng khi fix nhanh)
```bash
git checkout nodejs_react
git pull
git cherry-pick fix/docker
git push origin nodejs_react
```
📌 Dùng khi:
Nhánh mới chỉ có 1 commit

🧩 BƯỚC 5: Dọn nhánh MỚI (nếu không cần nữa)
```bash
git branch -d fix/docker
```

🔥 TÓM TẮT FLOW CHUẨN (NÊN GHI NHỚ)
```
nodejs_react
     ↓
  fix/docker   (code + commit)
     ↓
nodejs_react  (merge / cherry-pick)
```
----------
🧠 MẸO ĐI LÀM RẤT HAY

Nếu muốn xem trước merge
```bash
git diff nodejs_react..fix/docker
```

Nếu muốn merge không tạo commit
```bash
git merge --ff-only fix/docker
```
Nếu muốn ép lịch sử sạch
```bash
git rebase nodejs_react
```
(⚠️ chỉ dùng khi branch riêng)

----------------
📌 TÌNH HUỐNG CỦA BẠN (tóm tắt)

Ở máy công ty:

Nhánh local nodejs_react

Đã sửa code ❗

❌ Quên git push

Về máy nhà:

Cũng có nhánh nodejs_react

Nhưng remote chưa có code mới

👉 Vấn đề mấu chốt:
Code chỉ tồn tại trên máy công ty, GitHub chưa có.

✅ NGUYÊN TẮC SỐ 1 (RẤT QUAN TRỌNG)

GitHub KHÔNG THỂ cứu code nếu bạn CHƯA push từ máy công ty

👉 Máy nhà KHÔNG THỂ tự lấy code đó về
👉 Phải hành động từ máy công ty trước
🧯 CÁCH XỬ LÝ AN TOÀN 100%

🔹 CÁCH 1 (KHUYẾN NGHỊ – CHUẨN NHẤT)
👉 Quay lại máy công ty và PUSH NGAY
1️⃣ Kiểm tra nhánh
```
git branch
```
➡️ đảm bảo đang ở:
```
* nodejs_react
```

2️⃣ Commit (nếu chưa commit)
```
git status
git add .
git commit -m "Update nodejs react feature"
```
3️⃣ Push lên GitHub
```
git push origin nodejs_react
```
4️⃣ Về nhà → kéo code về
```
git checkout nodejs_react
git pull
```

✔️ Code quay về đầy đủ
✔️ Không mất gì

🔹 CÁCH 2: Chưa commit, CHƯA MUỐN push (tạm thời)

👉 Dùng stash để cất code

Ở máy công ty:
```
git stash push -m "WIP nodejs_react"
```
Sau đó:
```bash
git pull
git stash pop
```
⚠️ Nhưng cách này CHỈ dùng trên 1 máy,
❌ KHÔNG mang code sang máy khác

🔹 CÁCH 3: KHÔNG CÒN MÁY CÔNG TY 😱 (nguy hiểm)
👉 Nếu:

Máy công ty đã format

Repo bị xóa

Không backup

⛔ KHÔNG CÓ CÁCH CỨU
Vì Git chưa từng nhận commit

-------------
🧠 MẸO ĐI LÀM ĐỂ KHÔNG BAO GIỜ MẤT CODE
✅ 1. Commit nhỏ, push thường xuyên
```
git add .
git commit -m "WIP"
git push
```

👉 Commit ≠ deploy
👉 Commit là save game

✅ 2. Dùng nhánh WIP riêng
```
git switch -c wip/hoa-nodejs
git push -u origin wip/hoa-nodejs
```

✅ 3. Trước khi về → luôn chạy
```
git status
git log --oneline -3
```

✅ 4. Alias cứu mạng (rất nên)
```
git config --global alias.save "!git add . && git commit -m 'WIP' && git push"
```


Sau này chỉ cần:
```
git save
```
