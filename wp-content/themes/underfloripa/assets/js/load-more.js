let page = 2;
let loading = false;
let allPostsLoaded = false;

const spinner = document.getElementById("load-more-spinner");
const postsContainer = document.getElementById("posts-container");

if (!spinner || !postsContainer) {
  console.warn("Spinner or posts container not found.");
}

// Function to load more posts via AJAX
const loadMorePosts = () => {
  if (loading || allPostsLoaded) return;
  loading = true;

  // Show spinner
  spinner.style.visibility = "visible";

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
        spinner.style.visibility = "hidden";
        return;
      }

      const tempDiv = document.createElement("div");
      tempDiv.innerHTML = data;

      const newPosts = tempDiv.querySelectorAll(".archive-post");
      newPosts.forEach((post, index) => {
        post.classList.add("post-fade-in");
        post.style.animationDelay = `${index * 0.1}s`;
        postsContainer.appendChild(post);
      });

      page++;
    })
    .catch((error) => {
      console.error("Error loading more posts:", error);
    })
    .finally(() => {
      loading = false;
      spinner.style.visibility = "hidden";
    });
};

// IntersectionObserver to autoload posts when spinner enters viewport
const observer = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        loadMorePosts();
      }
    });
  },
  {
    root: null,
    rootMargin: "0px",
    threshold: 0,
  }
);

if (spinner) {
  observer.observe(spinner);
}
