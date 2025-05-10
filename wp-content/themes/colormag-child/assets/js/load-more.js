let page = 2;
let loading = false;
let allPostsLoaded = false;

const loadMorePosts = () => {
  if (loading) return;
  loading = true;
  document.getElementById("load-more-spinner").style.display = "block";

  const params = new URLSearchParams({
    action: "load_more_posts",
    page: page,
    nonce: my_ajax_obj.nonce,
    category_id: my_ajax_obj.category_id,
    search_query: my_ajax_obj.search_query,
    author_id: my_ajax_obj.author_id,
    post_type: my_ajax_obj.post_type,
  });

  fetch(`${my_ajax_obj.ajax_url}?${params.toString()}`)
    .then((response) => response.text())
    .then((data) => {
      if (data.includes("no-more-posts")) {
        allPostsLoaded = true;
        return;
      }

      document
        .getElementById("posts-container")
        .insertAdjacentHTML("beforeend", data);
      page++;
    })
    .catch((error) => {
      console.error("Error loading more posts:", error);
    })
    .finally(() => {
      loading = false;
      document.getElementById("load-more-spinner").style.display = "none";
    });
};

window.addEventListener("scroll", () => {
  if (loading || allPostsLoaded) return;

  const scrollPosition = window.scrollY + window.innerHeight;
  const bottom = document.documentElement.offsetHeight;

  if (scrollPosition >= bottom - 100) {
    loadMorePosts();
  }
});
